<?php
require_once 'src/config/db.php';
require_once 'src/controllers/ProdutosController.php';
require_once 'src/controllers/PedidosController.php';
require_once 'src/Router.php';

$router = Router::getInstance();

$router->add('GET', '/produtos', function () { 
    echo json_encode(["status" => "ok", "message" => "Rota GET /produtos funcionando!"]);
    
    if (isset($_GET["id"])) {
        ProdutosController::getInstance()->getById($_GET["id"]);
    } else {
        ProdutosController::getInstance()->list();
    }
});

$router->add('POST', '/produtos', function () { 
    echo json_encode(["status" => "ok", "message" => "Rota POST /produtos funcionando!"]);
    ProdutosController::getInstance()->create();
});

$router->add('DELETE', '/produtos', function () { 
    echo json_encode(["status" => "ok", "message" => "Rota DELETE /produtos funcionando!"]);
    ProdutosController::getInstance()->delete();
});

$router->add('PUT', '/produtos', function () { 
    echo json_encode(["status" => "ok", "message" => "Rota PUT /produtos funcionando!"]);
    ProdutosController::getInstance()->update();
});


$router->add('GET', '/pedidos', function () { 
    if(isset($_GET["id"])){
        PedidosController::getInstance()->getById($_GET["id"]);
    } else {
        PedidosController::getInstance()->list();
    }
});

$router->add('POST', '/pedidos', function () { PedidosController::getInstance()->create();});
$router->add('DELETE', '/pedidos', function () { PedidosController::getInstance()->delete();});
$router->add('PUT', '/pedidos', function () { PedidosController::getInstance()->update();});

Router::getInstance()->process();

