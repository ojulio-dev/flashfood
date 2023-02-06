<?php

namespace Model;

use Classes\Database;
use PDO;
use PDOException;

class Role extends Database {

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'role';
    }

    public function create()
    {

    }

    public function read()
    {
        try {
            
            $this->setSql("SELECT * FROM " . $this->table . "");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {
                return $this->stmt->fetchAll();

            } else {
                
                return false;
            }

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function setSql($sql)
    {
        $this->sql = $sql;
    }

    public function getSql()
    {
        return $this->sql;
    }

}