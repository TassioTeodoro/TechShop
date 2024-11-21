<?php
require_once 'src/models/Pedidos.php';

class PedidosController
{
    private $pedidos;
    private static $INSTANCE;

    public static function getInstance(){
        if(!isset(self::$INSTANCE)){
            self::$INSTANCE = new PedidosController();
        }
        return self::$INSTANCE;
    }

    public function __construct()
    {
        $this->pedidos = new Pedidos(Database::getInstance());
    }

    public function list()
    {
        $pedidos = $this->pedidos->list();
        echo json_encode($pedidos);

        http_response_code(200);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->produto_id) && isset($data->quantidade)) {
            try {
                $this->pedidos->create($data->produto_id, $data->quantidade);
                
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

    public function getByProdutoId($id)
    {
        if (isset($id)) {
            try {
                $pedidos = $this->pedidos->getByProdutoId($id);
                if ($pedidos) {
                    echo json_encode($pedidos);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Cadastro não encontrado"]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar cadastro"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id) && isset($data->id_produtos) && isset($data->quantidade)) {
            try {
                $count = $this->pedidos->update($data->id, $data->id_produtos, $data->quantidade);
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