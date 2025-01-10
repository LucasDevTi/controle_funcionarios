<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Empresa;
use App\Models\Funcionario;

class FuncionariosController extends Controller
{

    public function cadastrar()
    {
        $empresaModel = new Empresa;
        $empresas = $empresaModel->getAllEmpresas();

        $this->view('funcionarios/cadastrar', ['empresas' => $empresas]);
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $campos = ['nome_cad', 'email_cad', 'cpf_cad', 'empresa_cad'];

            /* Verifica se existe algum campo vazio */
            foreach ($campos as $campo) {
                if (isset($_POST[$campo]) && !empty($_POST[$campo])) {
                    /* Escapa string e salva na variável */
                    $$campo = htmlspecialchars($_POST[$campo], ENT_QUOTES);
                } else {

                    $data = array(
                        'success' => false,
                        'message' => "Todos os campos devem ser preenchidos"
                    );
                    echo json_encode($data);
                    return;
                }
            }

            $cpf_cad = preg_replace('/\D/', '', $cpf_cad);

            $data = [
                'nome' => $nome_cad,
                'cpf' => $cpf_cad,
                'email' => $email_cad,
                'id_empresa' => $empresa_cad,
            ];

            $funcionarioModel = new Funcionario();

            /* Válida se o funcionário já foi cadastrado pelo CPF*/
            $funcionario = $funcionarioModel->getByCpf($cpf_cad);

            if ($funcionario) {
                $data = array(
                    'success' => false,
                    'message' => "Já existe um funcionário com esse CPF"
                );
                echo json_encode($data);
                return;
            }

            /* Válida se o funcionário já foi cadastrado pelo email*/
            $funcionario = $funcionarioModel->getByEmail($email_cad);

            if ($funcionario) {
                $data = array(
                    'success' => false,
                    'message' => "Já existe um funcionário com esse email"
                );
                echo json_encode($data);
                return;
            }

            /* Cadastra o funcionário */
            $result = $funcionarioModel->insert($data);

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
                'message' => 'Houve um problema ao cadastrar o funcionário!'
            );

            echo json_encode($data);
            return;
        }
    }
    // public function editar($id)
    // {
    //     // Buscar os dados do funcionário pelo ID (simulado aqui)
    //     $funcionario = [
    //         'id' => $id,
    //         'nome' => 'João Silva',
    //         'email' => 'joao@example.com',
    //         'cargo' => 'Gerente'
    //     ];

    //     // Verificar se o funcionário foi encontrado
    //     if (!$funcionario) {
    //         die('Funcionário não encontrado.');
    //     }

    //     // Chamar a view de edição com os dados do funcionário
    //     $this->view('funcionarios/editar', ['funcionario' => $funcionario]);
    // }
}
