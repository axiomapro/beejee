<?php
namespace engine\core;
use engine\libs\Base;

class Controller {

    protected $view,$model;
    protected $first,$second,$third;

    public function __construct($controller,$action) {
        $this->view = new View($controller,$action);
        $this->model = $this->loadModel($controller);
        $this->first = Base::getURL(1);
        $this->second = Base::getURL(2);
        $this->third = Base::getURL(3);
    }

    // Найти класс модели для каждого контроллера
    private function loadModel($controller) {
        $path = "app/models/";
        $class = str_replace("/","\\",$path).ucfirst($controller);
        if (class_exists($class)) {
            return new $class;
        } else exit("{$class} not found");
    }

}