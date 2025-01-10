<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Funcionario
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllFuncionarios()
    {
        $stmt = $this->db->prepare("SELECT * FROM tbl_funcionario WHERE 1 ORDER BY id_funcionario DESC");
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getByCpf($cpf)
    {
        $stmt = $this->db->prepare("SELECT * FROM tbl_funcionario WHERE cpf = ?");
        $stmt->execute([$cpf]);
        return $stmt->fetch();
    }

    public function getByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM tbl_funcionario WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function insert($data)
    {
        $nome = $data['nome'];
        $cpf = $data['cpf'];
        $email = $data['email'];
        $id_empresa = $data['id_empresa'];
        $data_cadastro = date('Y-m-d H:i:s');
        $salario = 1500;
        $bonificacao = 0;

        $sql = "INSERT INTO tbl_funcionario (nome, cpf, rg, email, id_empresa, data_cadastro, salario, bonificacao) VALUES (:nome, :cpf, :rg, :email, :id_empresa, :data_cadastro, :salario, :bonificacao)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':rg', $rg);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id_empresa', $id_empresa);
        $stmt->bindParam(':data_cadastro', $data_cadastro);
        $stmt->bindParam(':salario', $salario);
        $stmt->bindParam(':bonificacao', $bonificacao);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM tbl_funcionario WHERE id_funcionario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->rowCount() > 0;
        }

        return false;
    }
}
