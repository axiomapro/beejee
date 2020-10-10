<?php
namespace app\controllers;
use engine\core\Controller;

class HandlerController extends Controller {

    public function add() {
        $email = strip_tags(trim($_POST['email']));
        $name = strip_tags(trim($_POST['name']));
        $text = strip_tags(trim($_POST['text']));
        $path = strip_tags(trim($_POST['path']));
        if (empty($email) || empty($name) || empty($text)) $this->model->message(false,"Заполните все поля");
        $this->model->add($email,$name,$text,$path);
    }

    public function edit() {
        if (!$_SESSION['admin']) $this->model->message(false,"Необходимо авторизация");
        $id = intval($_POST['id']);
        $text = strip_tags(trim($_POST['text']));
        if (empty($text)) $this->model->message(false,"Нельзя отправлять пустой текст");
        $this->model->edit($id,$text);
    }

    public function account() {
        if ($this->third == "logout") {
            session_unset();
            echo json_encode(["account"=>"logout"]);
        }
        if ($this->third == "login") {
            $login = strip_tags(trim($_POST['login']));
            $password = strip_tags(trim($_POST['password']));
            if (empty($login) || empty($password)) $this->model->message(false,"Заполните все поля");
            if ($login == "admin" && $password == "123") {
                $_SESSION['admin'] = true;
                echo json_encode(["account"=>"login"]);
            }
            else $this->model->message(false,"Неверный логин или пароль");
        }
    }

    public function status() {
        $this->model->toggleStatus(intval($_GET['id']));
    }

    public function sorting() {
        $_SESSION['sorting'] = intval($_GET['sorting']);
    }

}