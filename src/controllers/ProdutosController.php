<?php
require_once 'src/models/Produtos.php';

class ProdutosController
{
    private $produtos;

    public function __construct($db)
    {
        $this->produtos = new Produtos($db);
    }

    public function list()
    {
        $produtos = $this->produtos->list();
        echo json_encode($produtos);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->name) && isset($data->descricao) && isset($data->quantidade) && isset($data->preco)) {
            try {
                $this->produtos->create($data->name, $data->descricao, $data->quantidade, $data->preco);

                http_response_code(201);
                echo json_encode(["message" => "Produto criado com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao criar o produto."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function getById($id)
    {
        if (isset($id)) {
            try {
                $produto = $this->produtos->getById($id);
                if ($produto) {
                    echo json_encode($produto);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Produto não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar o produto."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id) && isset($data->name) && isset($data->descricao) && isset($data->quantidade) && isset($data->preco)) {
            try {
                $count = $this->produtos->update($data->id, $data->name, $data->descricao, $data->quantidade, $data->preco);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Produto atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar o produto."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar o produto."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function delete($id)
    {
        if (isset($id)) {
            try {
                $count = $this->produtos->delete($id);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Produto deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar o produto."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar o produto."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}
