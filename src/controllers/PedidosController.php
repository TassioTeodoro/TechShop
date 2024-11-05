<?php
require_once '../models/Pedidos.php';

class PedidosController
{
    private $pedidos;

    public function __construct($db)
    {
        $this->pedidos = new Pedidos($db);
    }

    public function list()
    {
        $pedidos = $this->pedidos->list();
        echo json_encode($pedidos);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id_produto) && isset($data->quantidade)&& isset($data->data_pedido)) {
            try {
                $this->user->create($data->id_produto, $data->quantidade,$data->data_pedido);

                http_response_code(201);
                echo json_encode(["message" => "Pedido criado com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao criar o pedido."]);
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
                $pedidos = $this->pedidos->getById($id);
                if ($pedidos) {
                    echo json_encode($pedidos);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Pedido não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar o pedido."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id) && isset($data->id_produto) && isset($data->quantidade) && isset($data->data_pedido)) {
            try {
                $count = $this->pedidos->update($data->id, $data->id_produto, $data->quantidade, $data->data_pedido);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Pedido atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar o pedido."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar o pedido."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id)) {
            try {
                $count = $this->pedidos->delete($data->id);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Pedido deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar o pedido."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar o pedido."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}