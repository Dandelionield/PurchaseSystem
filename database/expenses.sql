CREATE DATABASE expenses;

CREATE USER 'expenses'@'localhost' IDENTIFIED BY 'lambda73';
GRANT ALL PRIVILEGES ON expenses.* TO 'expenses'@'localhost';
FLUSH PRIVILEGES;

USE expenses;

CREATE TABLE IF NOT EXISTS user(

    user_dni VARCHAR(10),
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(30) NOT NULL,
	login BOOLEAN NOT NULL DEFAULT FALSE,
	admin BOOLEAN NOT NULL DEFAULT FALSE,
    state BOOLEAN NOT NULL DEFAULT TRUE,
	PRIMARY KEY (user_dni)

)ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS purchase(

    purchase_id INT AUTO_INCREMENT PRIMARY KEY,
    total DECIMAL(10,2) DEFAULT 0 CHECK (total >= 0),
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	details TEXT NOT NULL,
    user_dni VARCHAR(20) NOT NULL,
	state BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (user_dni) REFERENCES user(user_dni) ON DELETE CASCADE ON UPDATE CASCADE

)ENGINE = INNODB;;

USE expenses;

INSERT INTO user(

	user_dni,
	name,
	email,
	password,
	login,
	admin

) VALUES (

	'1111111111',
	'Dante',
	'dante.alighieri@unicolombo.edu.co',
	'lambda73',
	TRUE,
	TRUE

),(

	'2222222222',
	'Maomao',
	'maomao@unicolombo.edu.co',
	'maomao123',
	TRUE,
	FALSE

),(

	'3333333333',
	'Alex',
	'alex@unicolombo.edu.co',
	'123',
	TRUE,
	FALSE

),(

	'4444444444',
	'Danielle',
	'danielle@unicolombo',
	'321',
	TRUE,
	FALSE

),(

	'5555555555',
	'Doe',
	'doe@unicolombo.edu.co',
	'aa11',
	TRUE,
	FALSE

);