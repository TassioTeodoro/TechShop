<?php
require_once 'src/config/db.php';
require_once 'src/controllers/ProdutosController.php';
require_once 'src/controllers/PedidosController.php';
require_once 'src/Router.php';

$router = Router::getInstance();

$router->add('GET', '/produtos', function () { 
    if (isset($_GET["id"])) {
        ProdutosController::getInstance()->getById($_GET["id"]);
    } else {
        ProdutosController::getInstance()->list();
    }
});

$router->add('POST', '/produtos', function () { 
    ProdutosController::getInstance()->create();
});

$router->add('DELETE', '/produtos', function () { 
    ProdutosController::getInstance()->delete();
});

$router->add('PUT', '/produtos', function () { 
    ProdutosController::getInstance()->update();
});


$router->add('GET', '/pedidos', function () { 
    if(isset($_GET["id"])){
        PedidosController::getInstance()->getById($_GET["id"]);
    } else {
        PedidosController::getInstance()->list();
    }
});

$router->add('GET', '/pedidos/produtos', function () { 
    if(isset($_GET["id"])){
        PedidosController::getInstance()->getByProdutoId($_GET["id"]);
    }else {
        echo json_encode([
            "msg" => "Parametro Id do produto não presente"
        ]);
    }
});

$router->add('POST', '/pedidos', function () { 
    PedidosController::getInstance()->create();
});
$router->add('DELETE', '/pedidos', function () { 
    PedidosController::getInstance()->delete();
});
$router->add('PUT', '/pedidos', function () { 
    PedidosController::getInstance()->update();
});

Router::getInstance()->process();

