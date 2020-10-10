<?php
namespace app\models;
use engine\core\Model;

class Handler extends Model {

    public function add($email,$name,$text,$path) {
        $duplicate = $this->duplicate("email = ? and name = ? and text = ?",[$email,$name,$text]);
        if ($duplicate) $this->message(false,"Такое задание уже есть");
        $this->db->query("insert into task(email,name,text,status) values(?,?,?,?)",[$email,$name,$text,0]);
        echo json_encode(["action"=>"add","email"=>$email,"name"=>$name,"text"=>$text]);
    }

    public function edit($id,$text) {
        $this->db->query("update task set text = ? where id = ?",[$text,$id]);
        echo json_encode(["action"=>"edit","text"=>$text,"id"=>$id]);
    }

    public function toggleStatus($id) {
        $data = $this->db->row("select id,status from task where id = ?",[$id]);
        if (!$data['id']) return false;
        if ($data['status'] == 1) $status = 0;
        else $status = 1;
        $this->db->query("update task set status = ? where id = ?",[$status,$id]);
        echo json_encode(["status"=>$status]);
    }

}