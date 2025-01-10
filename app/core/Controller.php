<?php

namespace App\Core;

/**
 * Classe responsável por chamar a view com suporte a templates.
 */
class Controller
{
    public function view($view, $data = [])
    {
        $viewFile = "../app/views/{$view}.php";

        if (file_exists($viewFile)) {
            // Extrai dados para variáveis acessíveis na view
            extract($data);

            // Captura o conteúdo da view específica
            ob_start();
            require_once $viewFile;
            if ($view == 'login') {
                exit;
            }
            $content = ob_get_clean();

            // Inclui o template principal, passando o conteúdo da view
            require_once "../app/views/template.php";
        } else {
            die("View {$view} not found.");
        }
    }
}
