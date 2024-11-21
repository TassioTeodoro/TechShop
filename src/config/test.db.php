<?php
require_once 'src/config/db.php'; 
try {
    $db = Database::getInstance();
    if ($db) {
        echo "Conexão com o banco de dados bem-sucedida!";
    } else {
        echo "Falha ao conectar ao banco de dados.";
    }
} catch (Exception $e) {
    echo "Erro ao conectar: " . $e->getMessage();
}
