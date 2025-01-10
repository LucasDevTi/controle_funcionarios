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

    public function getAll()
    {
        $sql = "
        SELECT 
            f.id_funcionario, 
            f.nome, 
            f.cpf, 
            f.rg, 
            f.email, 
            e.nome AS empresa, 
            f.data_cadastro, 
            f.salario, 
            f.bonificacao 
        FROM 
            tbl_funcionario AS f
        INNER JOIN 
            tbl_empresa AS e
        ON 
            f.id_empresa = e.id_empresa
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
        $rg = null;

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

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tbl_funcionario WHERE id_funcionario = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $data)
    {
        if (!$id) {
            return false;
        }

        $fields = [];
        if (!empty($data['nome'])) {
            $fields[] = "nome = :nome";
        }
        if (!empty($data['cpf'])) {
            $fields[] = "cpf = :cpf";
        }
        if (!empty($data['email'])) {
            $fields[] = "email = :email";
        }
        if (!empty($data['id_empresa'])) {
            $fields[] = "id_empresa = :id_empresa";
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE tbl_funcionario SET " . implode(', ', $fields) . " WHERE id_funcionario = :id";
        $stmt = $this->db->prepare($sql);

        if (!empty($data['nome'])) {
            $stmt->bindParam(':nome', $data['nome']);
        }
        if (!empty($data['cpf'])) {
            $stmt->bindParam(':cpf', $data['cpf']);
        }

        if (!empty($data['email'])) {
            $stmt->bindParam(':email', $data['email']);
        }
        if (!empty($data['id_empresa'])) {
            $stmt->bindParam(':id_empresa', $data['id_empresa']);
        }

        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }
}
