<?php
require_once '../config/db.php';
require_once '../controllers/User.php';
require_once 'router.php';

header("Content-type: application/json; charset=UTF-8");

$router = new Router();
$pedidosController = new PedidosController($pdo);
$produtosController = new ProdutosController($pdo);

$router->add('get', '/pedidos', [$pedidosController, 'list']);
$router->add('get', '/pedidos/{id}', [$pedidosController, 'getById']);
$router->add('post', '/pedidos', [$pedidosController, 'create']);
$router->add('delete', '/pedidos/{id}', [$pedidosController, 'delete']);
$router->add('put', '/pedidos/{id}', [$pedidosController, 'update']);

$router->add('get', '/produtos', [$produtosController, 'list']);
$router->add('get', '/produtos/{id}', [$produtosController, 'getById']);
$router->add('post', '/produtos', [$produtosController, 'create']);
$router->add('delete', '/produtos/{id}', [$produtosController, 'delete']);
$router->add('put', '/produtos/{id}', [$produtosController, 'update']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$method = $_SERVER['REQUEST_METHOD'];
