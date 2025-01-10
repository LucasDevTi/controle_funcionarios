<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Funcionario;

class HomeController extends Controller
{
    public function index()
    {
        $funcionarioModal = new Funcionario();
        $funcionarios = $funcionarioModal->getAllFuncionarios();
        
        $this->view('home', [
            'title' => 'Dashboard',
            'pageTitle' => 'Bem-vindo ao Painel Administrativo',
            'activePage' => 'home',
            'funcionarios' => $funcionarios
        ]);
    }
}
