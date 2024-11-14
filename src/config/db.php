<?php
$host = 'localhost';
$db = 'api_db';
$user = 'postgres';
$pass = '123';

try {
    global $pdo;
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

?>