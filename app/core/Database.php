<?php
namespace App\Core;
/**
 * Classe responsável pela conexão com o banco de dados
 */
use PDO;

class Database
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new PDO("mysql:host=localhost;dbname=controle_funcionarios", "root", "");
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}
