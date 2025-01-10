<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        $this->view('login');
    }

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
            $password = md5($_POST['password']);

            $userModel = new User();
            $user = $userModel->getUserByEmailAndPassword($email, $password);

            if ($user) {
                $_SESSION['user'] = $user;

                header('Location: /controle_funcionarios/public/home');
            } else {

                $this->view('login', ['error' => 'Credenciais inválidas.']);
            }
        }
    }
}
