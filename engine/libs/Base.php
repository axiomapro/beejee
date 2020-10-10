<?php
namespace engine\libs;

class Base {

    public static function getURL($type) {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $part = explode('/',trim($url,'/'));
        return $part[$type-1];
    }

}