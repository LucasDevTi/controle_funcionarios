<?php
namespace App\Models;

use App\Core\Database;

class User
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getUserByEmailAndPassword($email, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM tbl_usuario WHERE login = ? AND senha = ?");
        $stmt->execute([$email, $password]);
        return $stmt->fetch();
    }
}
