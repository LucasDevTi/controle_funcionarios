<?php

/**
 * Classe responsável por verificar se o usuário está logado
 */
class Middleware
{
    public static function isAuth()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /controle_funcionarios/login');
            session_destroy();
            exit();
        }
    }
}
