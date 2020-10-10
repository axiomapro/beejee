<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

session_start();
use engine\core\Router;

spl_autoload_register(function($class) {
    $file = str_replace('\\','/',$class.'.php');
    if (file_exists($file)) require_once $file;
});

new Router();