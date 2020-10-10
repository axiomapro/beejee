<?php
namespace engine\core;
use PDO;
use PDOException;

class Database {

    private $pdo;

    public function __construct() {
        $config = require "engine/config/db.php";
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        $this->pdo = new PDO($dsn,$config['user'],$config['password']);
    }

    // Защита запроса
    public function query($sql,$params = []) {
        $stmt = $this->pdo->prepare($sql);
        $result = null;
        try {
            $this->pdo->beginTransaction();
            $stmt->execute($params = ($params != null) ? $params : null);
            if (strpos($sql,"insert") !== false) $result = $this->pdo->lastInsertId();
            else $result = $stmt;

            $this->pdo->commit();
        } catch(PDOException $e) {
            $this->pdo->rollback();
        }

        return $result;
    }

    // Вывести список
    public function all($sql,$params = []) {
        $result = $this->query($sql,$params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Вывести одну строку
    public function row($sql,$params = []) {
        $result = $this->query($sql,$params);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    // Считаем количество строк
    public function total($sql,$params = []) {
        $result = $this->query($sql,$params);
        return $result->fetchColumn();
    }


}