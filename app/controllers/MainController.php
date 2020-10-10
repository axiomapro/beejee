<?php
namespace app\controllers;

use engine\core\Controller;

class MainController extends Controller {

    public function index() {
        if (!$_SESSION['sorting']) $_SESSION['sorting'] = 1;
        if ($_SESSION['admin']) $itemEditVisible = " show";
        $tasks = $this->model->getTasksByPage($this->second);
        $maxPage = $this->model->getMaxPage();
        $page = $this->model->getNumberPage($maxPage,$this->second);
        $this->view->render("Main page",["tasks"=>$tasks,"maxPage"=>$maxPage,"page"=>$page,"itemEditVisible"=>$itemEditVisible]);
    }

}