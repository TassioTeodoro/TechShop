<?php
require_once '../config/db.php';

class Pedidos
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($id_produto, $quantidade, $data_pedido)
    {
        $sql = "INSERT INTO pedidos (id_produto,quantidade,data_pedido) VALUES (:id_produto, :quantidade, :data_pedido)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_produto', $id_produto);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':data_pedido', $data_pedido);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT * FROM pedidos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM pedidos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id,$id_produto,$quantidade, $data_pedido)
    {
        $sql = "UPDATE pedidos SET id_produto = :id_produto, quantidade = :quantidade, data_pedido = :data_pedido  WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_produto', $id_produto);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':data_pedido', $data_pedido);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM pedidos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}