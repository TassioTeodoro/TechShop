CREATE DATABASE api_db;

USE api_db;

CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL
);

CREATE TABLE pedidos (
    id SERIAL PRIMARY KEY,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,

    FOREIGN KEY (id_produto) REFERENCES produtos(id)
);