CREATE DATABASE api_db;

USE api_db;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    descriacao TEXT NOT NULL,
    quantidade INT(11) NOT NULL UNIQUE,
    preco INT(11) NOT NULL ,
);