CREATE DATABASE api_db;

USE api_db;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    quantidade INT(11) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL
);

CREATE TABLE pedidos (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_produto INT(11) NOT NULL,
    quantidade INT(11) NOT NULL,
    data_pedido DATE NOT NULL,
    FOREIGN KEY (id_produto) REFERENCES produtos(id)
);