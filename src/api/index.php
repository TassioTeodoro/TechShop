<?php
require_once 'src/config/db.php';
require_once 'src/controllers/ProdutosController.php';
require_once 'src/controllers/PedidosController.php';
require_once 'src/Router.php';

header("Content-type: application/json; charset=UTF-8");

$router = new Router();

$ProdutosController = new ProdutosController($pdo);
$PedidosController = new PedidosController($pdo);

$router->add('get', '/produtos', [$ProdutosController, 'list']);
$router->add('get', '/produtos/{id}', [$ProdutosController, 'getById']);
$router->add('post', '/produtos', [$ProdutosController, 'create']);
$router->add('delete', '/produtos/{id}', [$ProdutosController, 'delete']);
$router->add('put', '/produtos/{id}', [$ProdutosController, 'update']);


$router->add('get', '/pedidos', [$PedidosController, 'list']);
$router->add('get', '/pedidos/{id}', [$PedidosController, 'getById']);
$router->add('post', '/pedidos', [$PedidosController, 'create']);
$router->add('delete', '/pedidos/{id}', [$PedidosController, 'delete']);
$router->add('put', '/pedidos/{id}', [$PedidosController, 'update']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($requestedPath, $method);

