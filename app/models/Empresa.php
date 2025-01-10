<?php
namespace App\Models;

use App\Core\Database;

class Empresa
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllEmpresas()
    {
        $stmt = $this->db->prepare("SELECT * FROM tbl_empresa WHERE 1");
        $stmt->execute([]);
        return $stmt->fetchAll();
    }
}
