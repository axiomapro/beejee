<?php
namespace app\models;
use engine\core\Model;

class Main extends Model {

    public function getTasksByPage($page = 1) {
        $order = $this->sortBy();
        $maxPage = $this->getMaxPage();
        $interval = ($this->getNumberPage($maxPage,$page) - 1) * 5;
        $limit = "{$interval},5";
        return $this->db->all("select * from task order by {$order} limit {$limit}");
    }

    private function sortBy() {
        $result = "name asc";
        if ($_SESSION['sorting'] == 2) $result = "email asc";
        if ($_SESSION['sorting'] == 3) $result = "status desc";
        return $result;
    }

    public function getNumberPage($maxPage,$page) {
        if ($page < 0 || $page == null) $page = 1;
        if ($page > $maxPage) $page = $maxPage;
        return $page;
    }

    public function getMaxPage() {
        $totalTasks = $this->db->total("select count(1) from task");
        return ceil($totalTasks / 5);
    }

}