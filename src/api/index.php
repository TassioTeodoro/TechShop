<?php
require_once '../config/db.php';
require_once '../controllers/User.php';
require_once '../router.php';

header("Content-type: application/json; charset=UTF-8");

$router = new Router();

$produtosController = new ProdutosController($pdo);
$pedidosController = new PedidosController($pdo);

$router->add('get', '/', [$produtosController, 'list']);
$router->add('get', '/{id}', [$produtosController, 'getById']);
$router->add('post', '/', [$produtosController, 'create']);
$router->add('delete', '/{id}', [$produtosController, 'delete']);
$router->add('put', '/{id}', [$produtosController, 'update']);

$router->add('get', '/', [$pedidosController, 'list']);
$router->add('get', '/{id}', [$pedidosController, 'getById']);
$router->add('post', '/', [$pedidosController, 'create']);
$router->add('delete', '/{id}', [$pedidosController, 'delete']);
$router->add('put', '/{id}', [$pedidosController, 'update']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$pathItems = explode("/", $requestedPath);
$requestedPath = "/" . $pathItems[3] . ($pathItems[4] ? "/" . $pathItems[4] : "");

$router->dispatch($requestedPath);

