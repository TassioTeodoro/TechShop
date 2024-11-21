<?php
require_once 'src/config/db.php';

class Pedidos
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($id_produtos, $quantidade )
    {
        $sql = "INSERT INTO pedidos (id_produto,quantidade) VALUES (:id_produtos, :quantidade)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_produtos', $id_produtos);
        $stmt->bindParam(':quantidade', $quantidade);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT pro.name, ped.quantidade, pro.preco FROM pedidos ped join produtos pro on pro.id = ped.id_produto";
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

    public function getByProdutoId($id)
    {
        $sql = "SELECT * FROM pedidos WHERE id_produtos = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id,$id_produtos,$quantidade)
    {
        $sql = "UPDATE pedidos SET id_produtos = :id_produtos, quantidade = :quantidade  WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_produtos', $id_produtos);
        $stmt->bindParam(':quantidade', $quantidade);
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