<?php

namespace Model;

use Classes\Database;

use PDO;
use PDOException;

class Table extends Database {
    private $stmt, $sql, $table, $conn;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'table';
    }

    public function create()
    {
        
    }

    public function read()
    {
        try {
            
            $this->setSql("SELECT * FROM `" . $this->table . "` WHERE status = 1");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update($data, $id)
    {

    }

    public function updateByField($data, string $field, $userId)
    {

    }

    public function delete()
    {

    }

    // Getters e Setters
    public function setSql($sql) {
        $this->sql = $sql;
    }

    public function getSql() {
        return $this->sql;
    }
}