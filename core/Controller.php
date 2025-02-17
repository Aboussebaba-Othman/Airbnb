<?php
namespace Core;

abstract class Controller {
    protected $view;

    public function __construct() {
        ob_start();
    }

    protected function view($view, $data = []) {
        extract($data);

        $viewPath = "../app/views/" . $view . ".php";       

        if (file_exists($viewPath)) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();
            
            if (isset($data['layout'])) {
                $layoutPath = "../app/views/layouts/" . $data['layout'] . ".php";
                if (file_exists($layoutPath)) {
                    require $layoutPath;
                    return;
                }
            }
            
            echo $content;
        } else {
            throw new \Exception("View $view not found");
        }
    }

    protected function redirect($url) {
        ob_clean();
        header("Location: $url");
        exit;
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function getBody() {
        if ($this->isPost()) {
            return $_POST;
        }
        return $_GET;
    }
}
