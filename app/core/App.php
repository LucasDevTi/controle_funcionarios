<?php

namespace App\Core;

use Middleware;

class App
{
    protected $controller = 'LoginController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        // session_start();

        $url = $this->parseUrl();

        if (!empty($url[0]) && $url[0] !== 'login') {
            Middleware::isAuth();
        }

        /* Verifica a existência do controller, caso exista o arquivo o atributo recebe o nome do controller */
        if (isset($url[0]) && file_exists("../app/controllers/{$url[0]}Controller.php")) {
            $this->controller = $url[0] . 'Controller';
            unset($url[0]);
        }

        /* É instanciado o objeto do controller requerido */
        $this->controller = "App\\Controllers\\" . $this->controller;
        $this->controller = new $this->controller;

        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        /* Chama o método do controller */
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
