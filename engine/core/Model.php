<?php
namespace engine\core;

class Model {

    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    protected function duplicate($where,$params) {
        $result = true;
        $sql = "select count(1) from task where {$where} limit 1";
        if ($this->db->total($sql,$params) == 0) $result = false;
        return $result;
    }

    public function message($status,$message) {
        exit(json_encode(["status"=>$status,"message"=>$message]));
    }

}