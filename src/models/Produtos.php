<?php
require_once 'src/config/db.php';

class Produtos
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($name, $descricao, $quantidade, $preco)
    {
        $sql = "INSERT INTO produtos (name,descricao,quantidade,preco) VALUES (:name, :descricao, :quantidade, :preco)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':preco', $preco);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT * FROM produtos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $descricao,$quantidade, $preco)
    {
        $sql = "UPDATE produtos SET name = :name, descricao = :descricao, quantidade = :quantidade, preco = :preco WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':preco', $preco);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}