<?php

namespace Classes;

use PDO;
use Classes\Database;
use PDOException;

require_once(__DIR__ . '/../config/config.php');

class Functions extends Database {

    private $sql, $conn, $stmt;

    public function __construct()
    {
        $this->conn = parent::conn();
    }

    public function readByTableId($id, $table)
    {
        try {

            $this->setSql("SELECT * FROM `{$table}` WHERE  " . ($table == 'product_category' ? 'category' : $table) . "_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {

                return $this->stmt->fetch();
            } else {

                return false;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }

        return $this->getSql();
    }

    public function changeStatus($status, $id, string $table): bool
    {
        try {

            $this->setSql("UPDATE `{$table}` SET status = '$status' WHERE " . ($table !== 'product_category' ? $table : 'category') . "_id = $id");
            
            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {

                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
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