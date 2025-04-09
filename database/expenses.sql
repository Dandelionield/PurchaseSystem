CREATE DATABASE expenses WITH ENCODING = 'UTF8' LC_COLLATE = 'es_ES.UTF-8'  LC_CTYPE = 'es_ES.UTF-8' TEMPLATE = template0;

CREATE ROLE expenses WITH LOGIN PASSWORD 'lambda73';

ALTER DATABASE expenses OWNER TO expenses;

GRANT ALL PRIVILEGES ON DATABASE expenses TO expenses;

\c expenses;

CREATE SCHEMA IF NOT EXISTS expense AUTHORIZATION expenses;
ALTER DEFAULT PRIVILEGES IN SCHEMA expense GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO expenses;

CREATE SCHEMA IF NOT EXISTS super AUTHORIZATION expenses;
ALTER DEFAULT PRIVILEGES IN SCHEMA super GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO expenses;

CREATE SCHEMA IF NOT EXISTS storage AUTHORIZATION expenses;
ALTER DEFAULT PRIVILEGES IN SCHEMA storage GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO expenses;

SET ROLE expenses;

CREATE TABLE IF NOT EXISTS super.user(

	user_dni VARCHAR(20),
	name VARCHAR(100) NOT NULL,
	email VARCHAR(100) UNIQUE DEFAULT NULL,
	address VARCHAR(100) DEFAULT NULL,
	state BOOLEAN NOT NULL DEFAULT true,
	PRIMARY KEY (user_dni)

);

CREATE TABLE IF NOT EXISTS super.employee(

	employee_code VARCHAR(10),
	user_dni VARCHAR(20) NOT NULL UNIQUE,
	password VARCHAR(30) NOT NULL,
	admin BOOLEAN NOT NULL DEFAULT false,
	state BOOLEAN NOT NULL DEFAULT true,
	PRIMARY KEY (employee_code),
	FOREIGN KEY (user_dni) REFERENCES super.user(user_dni) ON DELETE CASCADE ON UPDATE CASCADE

);

CREATE TABLE IF NOT EXISTS storage.item(

	item_id SERIAL,
	item_code VARCHAR(10) NOT NULL UNIQUE,
	name VARCHAR(100) NOT NULL,
	price DECIMAL NOT NULL CHECK (price>0),
	stock DECIMAL NOT NULL CHECK (stock>=0),
	state BOOLEAN NOT NULL DEFAULT true,
	PRIMARY KEY (item_id)

);

CREATE TABLE IF NOT EXISTS expense.purchase(

	purchase_id SERIAL,
	purchase_code TEXT NOT NULL UNIQUE,
	total DECIMAL NOT NULL DEFAULT 0 CHECK (total>=0),
	purchase_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	user_dni VARCHAR(20) NOT NULL,
	employee_code VARCHAR(10) NOT NULL,
	PRIMARY KEY (purchase_id),
	FOREIGN KEY (user_dni) REFERENCES super.user(user_dni) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (employee_code) REFERENCES super.employee(employee_code) ON DELETE CASCADE ON UPDATE CASCADE

);

CREATE TABLE IF NOT EXISTS expense.buyout(

	buyout_id SERIAL,
	purchase_id INT NOT NULL,
	item_id INT NOT NULL,
	quantity DECIMAL NOT NULL CHECK (quantity>0),
	total DECIMAL NOT NULL CHECK (total>0),
	PRIMARY KEY (buyout_id),
	FOREIGN KEY (purchase_id) REFERENCES expense.purchase(purchase_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (item_id) REFERENCES storage.item(item_id) ON DELETE CASCADE ON UPDATE CASCADE

);

CREATE TYPE expense.purchased_item AS (

	item_id INT,
	quantity DECIMAL

);

CREATE OR REPLACE PROCEDURE expense.commit_purchase(IN e_employee_code VARCHAR(10), IN u_user_dni VARCHAR(20), IN items expense.purchased_item[], OUT p_purchase_id INT) LANGUAGE plpgsql AS $$

	DECLARE

		purchase_total DECIMAL := 0;
		p_item expense.purchased_item;
		item_record storage.item%ROWTYPE;

	BEGIN

		IF NOT EXISTS (

			SELECT 1 FROM

				super.user
				
			WHERE user_dni = u_user_dni AND state=true

		) THEN

			ROLLBACK;
			RAISE EXCEPTION 'El usuario con DNI % no existe.', u_user_dni;

		END IF;

		IF NOT EXISTS (

			SELECT 1 FROM

				super.employee
				
			WHERE employee_code = e_employee_code AND state=true

		) THEN

			ROLLBACK;
			RAISE EXCEPTION 'El empleado con codigo % no existe.', e_employee_code;

		END IF;

		INSERT INTO expense.purchase (

			user_dni,
			employee_code

		) VALUES (

			u_user_dni,
			e_employee_code

		) RETURNING purchase_id INTO p_purchase_id;

		FOREACH p_item IN ARRAY items LOOP

			SELECT * INTO

				item_record

			FROM

				storage.item

			WHERE

				item_id = p_item.item_id

			FOR UPDATE;  -- Bloquea el registro para evitar race conditions

			IF NOT FOUND THEN

				ROLLBACK;
				RAISE EXCEPTION 'El item con identificador % no existe.', p_item.item_id;

			END IF;

			IF p_item.quantity > item_record.stock THEN

				ROLLBACK;
				RAISE EXCEPTION 'Stock insuficiente para % (Disponible: %, Solicitado: %)', item_record.name, item_record.stock, p_item.quantity;

			END IF;

			INSERT INTO expense.buyout(

				purchase_id, 
				item_id, 
				quantity, 
				total

			) VALUES (

				p_purchase_id,
				p_item.item_id,
				p_item.quantity,
				p_item.quantity * item_record.price

			);

			UPDATE

				storage.item

			SET

				stock = item_record.stock - p_item.quantity

			WHERE item_id = p_item.item_id;

			purchase_total := purchase_total + (p_item.quantity * item_record.price);

		END LOOP;

		UPDATE

			expense.purchase

		SET

			total = purchase_total

		WHERE purchase_id = p_purchase_id;

		COMMIT;

	END;

$$;

CREATE OR REPLACE FUNCTION super.employee_user_state() RETURNS TRIGGER AS $$

	BEGIN
	
		UPDATE

			super.employee

		SET

			state=NEW.state

		WHERE user_dni IN (

			SELECT

				e.user_dni

			FROM

				super.employee AS e

			JOIN super.user AS u ON

				e.user_dni = u.user_dni

			WHERE u.user_dni = NEW.user_dni

		);

		RETURN NEW;
	
	END;

$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION expense.generate_purchase_code() RETURNS TRIGGER LANGUAGE plpgsql AS $$

	BEGIN

		NEW.purchase_code := md5(NEW.purchase_id::TEXT || NEW.employee_code::TEXT || NEW.user_dni::TEXT || NEW.purchase_date::TEXT);
		RETURN NEW;

	END;

$$;

CREATE TRIGGER invoke_unique_relation_utilities_model AFTER UPDATE ON super.user

	FOR EACH ROW
	
		EXECUTE FUNCTION super.employee_user_state();

CREATE TRIGGER invoke_generate_purchase_code BEFORE INSERT ON expense.purchase

	FOR EACH ROW

		EXECUTE FUNCTION expense.generate_purchase_code();