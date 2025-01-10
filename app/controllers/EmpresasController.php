<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Empresa;
use App\Models\Funcionario;

class EmpresasController extends Controller
{

    public function cadastro()
    {
        $this->view('empresas/cadastro', []);
    }

    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_POST['nome']) && empty($_POST['nome'])) {
                $data = array(
                    'success' => false,
                    'message' => "Por favor preencha um nome"
                );
                echo json_encode($data);
                return;
            }

            $nome = htmlspecialchars($_POST['nome'], ENT_QUOTES);

            $empresaModel = new Empresa();
            $result = $empresaModel->insert($nome);

            if ($result) {
                $data = array(
                    'success' => true,
                    'message' => 'Cadastro realizado com sucesso'
                );
                echo json_encode($data);
                return;
            }

            $data = array(
                'success' => false,
                'message' => 'Houve um problema ao cadastrar a empresa!'
            );

            echo json_encode($data);
            return;
        }
    }
}
