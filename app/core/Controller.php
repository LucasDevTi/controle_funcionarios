<?php
namespace App\Core;

/**
 * Classe responsável por chamar a view
 */
class Controller
{
    public function view($view, $data = [])
    {
        $viewFile = "../app/views/{$view}.php";
        if (file_exists($viewFile)) {
            extract($data);
            require_once $viewFile;
        } else {
            die("View {$view} not found.");
        }
    }
}
