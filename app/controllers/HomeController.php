<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Funcionario;
use DateTime;

class HomeController extends Controller
{
    public function index()
    {
        $funcionarioModal = new Funcionario();
        $funcionarios = $funcionarioModal->getAllFuncionarios();
        $dataAtual = new DateTime();

        foreach ($funcionarios as $index => $funcionario) {
            /* Verificando data de cadastro de funcionário na empresa */
            $dataCadastro = $funcionario['data_cadastro'];
            $dataCadastroObj = new DateTime($dataCadastro);
            $diferenca = $dataCadastroObj->diff($dataAtual);

            if ($diferenca->y >= 5) {
                $funcionarios[$index]['background'] = "#dc3545";
            } else if ($diferenca->y >= 1) {
                $funcionarios[$index]['background'] = "#007bff";
            } else {
                $funcionarios[$index]['background'] = "";
            }

            /* Formatando para o padrão BR */
            $date = new DateTime($dataCadastro);
            $funcionarios[$index]['data_cadastro'] = $date->format('d/m/Y');

            /* Formatano para Real */
            $funcionarios[$index]['salario'] = number_format($funcionarios[$index]['salario'], 2, ',', '.');
        }
        // die;

        $this->view('home', [
            'title' => 'Dashboard',
            'pageTitle' => 'Bem-vindo ao Painel Administrativo',
            'activePage' => 'home',
            'funcionarios' => $funcionarios
        ]);
    }
}
