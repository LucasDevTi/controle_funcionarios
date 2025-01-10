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

    public function editar($id)
    {

        $funcionarioModel = new Funcionario();
        $funcionario = $funcionarioModel->getById($id);

        if ($funcionario) {

            $empresaModel = new Empresa;
            $empresas = $empresaModel->getAllEmpresas();

            $this->view('funcionarios/editar', ['funcionario' => $funcionario, 'empresas' => $empresas]);
        } else {
            $this->view('home');
        }
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

            if (!$this->validarCPF($cpf_cad)) {
                $data = array(
                    'success' => false,
                    'message' => "CPF inválido"
                );
                echo json_encode($data);
                return;
            }

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

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $campos = ['nome_edit', 'email_edit', 'cpf_edit', 'empresa_edit', 'id'];

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

            if (!$this->validarCPF($cpf_edit)) {
                $data = array(
                    'success' => false,
                    'message' => "CPF inválido"
                );
                echo json_encode($data);
                return;
            }

            $cpf_edit = preg_replace('/\D/', '', $cpf_edit);

            $data = [
                'nome' => $nome_edit,
                'cpf' => $cpf_edit,
                'email' => $email_edit,
                'id_empresa' => $empresa_edit,
            ];

            $funcionarioModel = new Funcionario();

            /* Válida se o funcionário já foi cadastrado pelo CPF*/
            $funcionario = $funcionarioModel->getByCpf($cpf_edit);

            if ($funcionario) {
                if ($id != $funcionario['id_funcionario']) {
                    $data = array(
                        'success' => false,
                        'message' => "Já existe um funcionário com esse CPF"
                    );
                    echo json_encode($data);
                    return;
                }
            }

            /* Válida se o funcionário já foi cadastrado pelo email*/
            $funcionario = $funcionarioModel->getByEmail($email_edit);

            if ($funcionario) {
                if ($id != $funcionario['id_funcionario']) {
                    $data = array(
                        'success' => false,
                        'message' => "Já existe um funcionário com esse email"
                    );
                    echo json_encode($data);
                    return;
                }
            }

            /* Cadastra o funcionário */
            $result = $funcionarioModel->update($id, $data);

            if ($result) {
                $data = array(
                    'success' => true,
                    'message' => 'Alteração realizada com sucesso'
                );
                echo json_encode($data);
                return;
            }

            $data = array(
                'success' => false,
                'message' => 'Houve um problema ao atualizar os dados do funcionário!'
            );

            echo json_encode($data);
            return;
        }
    }

    public function excluir()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['id']) && !empty($_POST['id'])) {
                /* Escapa string e salva na variável */
                $id = htmlspecialchars($_POST['id'], ENT_QUOTES);
            } else {
                $data = array(
                    'success' => false,
                    'message' => "Não foi possivel excluir o funcionário"
                );
                echo json_encode($data);
                return;
            }

            $funcionarioModel = new Funcionario();

            $result = $funcionarioModel->delete($id);

            if ($result) {
                $data = array(
                    'success' => true,
                    'message' => 'Funcionário excluido com sucesso'
                );
                echo json_encode($data);
                return;
            }

            $data = array(
                'success' => false,
                'message' => 'Houve um problema ao excluir o funcionário!'
            );

            echo json_encode($data);
            return;
        }
    }

    private function validarCPF($cpf)
    {

        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11) {
            return false;
        }

        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += (int) $cpf[$i] * (10 - $i);
        }
        $resto = ($soma * 10) % 11;
        if ($resto == 10 || $resto == 11) {
            $resto = 0;
        }
        if ($resto != (int) $cpf[9]) {
            return false;
        }

        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += (int) $cpf[$i] * (11 - $i);
        }
        $resto = ($soma * 10) % 11;
        if ($resto == 10 || $resto == 11) {
            $resto = 0;
        }
        if ($resto != (int) $cpf[10]) {
            return false;
        }

        return true;
    }
}
