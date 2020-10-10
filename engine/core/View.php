<?php
namespace engine\core;

class View {

    private $controller, $action;
    private $layout = "default";

    public function __construct($c,$a) {
        $this->controller = $c;
        $this->action = $a;
    }

    // Получить вид и вывести вместе с переменными
    public function render($title,$vars = []) {
        $file = "app/views/fragments/{$this->controller}/{$this->action}.php";
        extract($vars);
        if (file_exists($file)) {
            ob_start();
            require_once $file;
            $content = ob_get_clean();
            require_once "app/views/layouts/{$this->layout}.php";
        } else exit($file.' not found');
    }

}