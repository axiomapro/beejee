<?php
namespace engine\core;

class Router {

    private $controller,$action;

    public function __construct() {
        $url = parse_url(trim($_SERVER['REQUEST_URI']), PHP_URL_PATH);
        $part = explode('/',trim($url,'/'));
        $this->controller = $part[0];
        $this->action = $part[1];
        $this->setControllerAndAction();
        $path = "app\controllers\\".ucfirst($this->controller)."Controller";
        if (class_exists($path) && method_exists($path,$this->action)) {
            $class = new $path($this->controller,$this->action);
            $method = $this->action;
            $class->$method();
        } else echo "404 not found";
    }

    private function setControllerAndAction() {
        if ($this->controller == "page" && is_numeric($this->action)) {
            $this->controller = "main";
            $this->action = "index";
        }
        if (empty($this->controller)) $this->controller = "main";
        if (empty($this->action)) $this->action = "index";
    }


}