-- Crear la base de datos
CREATE DATABASE expenses;

-- Crear usuario y asignar privilegios
CREATE USER 'expenses'@'localhost' IDENTIFIED BY 'lambda73';
GRANT ALL PRIVILEGES ON expenses.* TO 'expenses'@'localhost';
FLUSH PRIVILEGES;

USE expenses;

-- Tablas (sin esquemas, usar prefijos)
CREATE TABLE IF NOT EXISTS user (
    user_dni VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    address VARCHAR(100),
    state BOOLEAN DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS employee (
    employee_code VARCHAR(10) PRIMARY KEY,
    user_dni VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(30) NOT NULL,
    admin BOOLEAN DEFAULT FALSE,
    state BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_dni) REFERENCES user(user_dni) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS item (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    item_code VARCHAR(10) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) CHECK (price > 0),
    stock DECIMAL(10,2) CHECK (stock >= 0),
    state BOOLEAN DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS purchase (
    purchase_id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_code TEXT NOT NULL UNIQUE,
    total DECIMAL(10,2) DEFAULT 0 CHECK (total >= 0),
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_dni VARCHAR(20) NOT NULL,
    employee_code VARCHAR(10) NOT NULL,
    FOREIGN KEY (user_dni) REFERENCES user(user_dni) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (employee_code) REFERENCES employee(employee_code) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS buyout (
    buyout_id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity DECIMAL(10,2) CHECK (quantity > 0),
    total DECIMAL(10,2) CHECK (total > 0),
    FOREIGN KEY (purchase_id) REFERENCES purchase(purchase_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (item_id) REFERENCES item(item_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Procedimiento almacenado (simplificado sin tipos compuestos)
DELIMITER $$
CREATE PROCEDURE expense_commit_purchase(
    IN e_employee_code VARCHAR(10),
    IN u_user_dni VARCHAR(20),
    IN items JSON -- Usar JSON para emular array de objetos
)
BEGIN
    DECLARE p_purchase_id INT;
    DECLARE i INT DEFAULT 0;
    DECLARE item_id INT;
    DECLARE quantity DECIMAL(10,2);
    DECLARE item_price DECIMAL(10,2);
    DECLARE item_stock DECIMAL(10,2);
    DECLARE purchase_total DECIMAL(10,2) DEFAULT 0;

    -- Validar usuario y empleado
    IF NOT EXISTS (SELECT 1 FROM user WHERE user_dni = u_user_dni AND state = TRUE) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Usuario no existe o está inactivo';
    END IF;

    IF NOT EXISTS (SELECT 1 FROM employee WHERE employee_code = e_employee_code AND state = TRUE) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Empleado no existe o está inactivo';
    END IF;

    -- Insertar compra
    INSERT INTO purchase (user_dni, employee_code) 
    VALUES (u_user_dni, e_employee_code);
    SET p_purchase_id = LAST_INSERT_ID();

    -- Procesar items (usar JSON)
    WHILE i < JSON_LENGTH(items) DO
        SET item_id = JSON_EXTRACT(items, CONCAT('$[', i, '].item_id'));
        SET quantity = JSON_EXTRACT(items, CONCAT('$[', i, '].quantity'));

        -- Obtener datos del item
        SELECT price, stock INTO item_price, item_stock 
        FROM item 
        WHERE item_id = item_id FOR UPDATE;

        IF item_stock < quantity THEN
            SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = CONCAT('Stock insuficiente para el item ', item_id);
        END IF;

        -- Actualizar stock y registrar compra
        UPDATE item SET stock = stock - quantity WHERE item_id = item_id;
        INSERT INTO buyout (purchase_id, item_id, quantity, total) 
        VALUES (p_purchase_id, item_id, quantity, quantity * item_price);

        SET purchase_total = purchase_total + (quantity * item_price);
        SET i = i + 1;
    END WHILE;

    -- Actualizar total de la compra
    UPDATE purchase SET total = purchase_total WHERE purchase_id = p_purchase_id;
END$$
DELIMITER ;

-- Triggers
DELIMITER $$
CREATE TRIGGER invoke_generate_purchase_code 
BEFORE INSERT ON purchase
FOR EACH ROW
BEGIN
    SET NEW.purchase_code = MD5(CONCAT(NEW.purchase_id, NEW.employee_code, NEW.user_dni, NEW.purchase_date));
END$$
DELIMITER ;

USE expenses;

-- Insertar usuarios
INSERT INTO user (user_dni, name, email) VALUES
('1111111111', 'Dante', 'dante.alighieri@unicolombo.edu.co'),
('2222222222', 'Maomao', 'maomao@unicolombo.edu.co'),
('3333333333', 'Alex', 'alex@unicolombo.edu.co'),
('4444444444', 'Danielle', 'danielle@unicolombo'),
('5555555555', 'Doe', 'doe@unicolombo.edu.co');

-- Insertar empleados
INSERT INTO employee (employee_code, user_dni, password, admin) VALUES
('1110010001', '1111111111', 'lambda73', TRUE),
('2220020002', '2222222222', 'maomao123', FALSE);

-- Insertar items
INSERT INTO item (item_code, name, price, stock) VALUES
('FT-M', 'Manzana', 5000, 30),
('FT-P', 'Pera', 2000, 50);

-- Llamar al procedimiento (usar JSON para items)
CALL expense_commit_purchase(
    '1110010001',
    '1111111111',
    JSON_ARRAY(
        JSON_OBJECT('item_id', 1, 'quantity', 2),
        JSON_OBJECT('item_id', 2, 'quantity', 10)
    )
);

-- Consultas finales
SELECT * FROM storage_item;
SELECT * FROM expense_purchase;
SELECT * FROM expense_buyout;