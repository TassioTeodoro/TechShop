<?php
require_once 'src/config/db.php'; // Ajuste o caminho para onde a classe Database está salva

try {
    // Tenta obter a instância da conexão com o banco de dados
    $db = Database::getInstance();
    if ($db) {
        echo "Conexão com o banco de dados bem-sucedida!";
    } else {
        echo "Falha ao conectar ao banco de dados.";
    }
} catch (Exception $e) {
    // Captura e exibe qualquer erro
    echo "Erro ao conectar: " . $e->getMessage();
}
