<?php

namespace App\Core;

/**
 * Classe responsável por verificar se o usuário está logado
 */

class Middleware
{
    public static function isAuth()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /controle_funcionarios/public/login');
            session_destroy();
            exit();
        }
    }

    public static function isLogin()
    {
        if (isset($_SESSION['user'])) {
            header('Location: /controle_funcionarios/public/home');
            exit();
        }
    }
}
