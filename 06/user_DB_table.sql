CREATE DATABASE user_DB_table;
USE user_DB_table;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50)
);

CREATE TABLE items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    price DECIMAL(5,2)
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_id INT
);

INSERT INTO users (username, password)
VALUES ('test', '1234'), ('admin', 'admin');

INSERT INTO items (name, price) VALUES
('Brood', 2.50),
('Broccoli', 1.75),
('Melk', 1.50),
('Appels', 2.25),
('Pasta', 1.80);