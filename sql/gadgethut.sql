CREATE DATABASE IF NOT EXISTS gadgethut;
USE gadgethut;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255)
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  price DECIMAL(10,2),
  description TEXT,
  image VARCHAR(255)
);

INSERT INTO products (name, price, description) VALUES
('Refurbished iPhone 12', 35000, 'Like new condition.'),
('Refurbished Dell Laptop', 42000, 'i5 11th Gen, 8GB RAM.'),
('Samsung Galaxy S21', 38000, 'Excellent battery life.');
