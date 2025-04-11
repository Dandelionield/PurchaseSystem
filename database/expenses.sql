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