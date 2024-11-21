<?php

use PHPUnit\Framework\TestCase;

require_once 'src/config/db.php'; 

class DatabaseTest extends TestCase
{
    public function testDatabaseConnection()
    {
        $db = Database::getInstance();
        $this->assertInstanceOf(PDO::class, $db, "A conexão com o banco de dados deve retornar uma instância de PDO.");
    }

    public function testDatabaseSingleton()
    {
        $db1 = Database::getInstance();
        $db2 = Database::getInstance();

        $this->assertSame($db1, $db2, "O método getInstance() deve retornar sempre a mesma instância (singleton).");
    }
}
