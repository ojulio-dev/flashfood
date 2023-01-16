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

    public function create($data)
    {
        
        try {
        
            $this->setSql("INSERT INTO `" . $this->table . "` (table_number, status) VALUES (:tableNumber, :status)");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->bindValue(':tableNumber', $data['tableNumber']);
            $this->stmt->bindValue(':status', $data['status']);

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function read()
    {
        try {
            
            $this->setSql("SELECT * FROM `" . $this->table . "` WHERE status = 1 ORDER BY table_number");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function readDashboard()
    {
        try {
            
            $this->setSql("SELECT * FROM `" . $this->table . "` ORDER BY table_number");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function readByTableNumber($tableNumber)
    {
        try {
            
            $this->setSql("SELECT * FROM `" . $this->table . "` WHERE status = 1 AND table_number = '$tableNumber'");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function readByTableId($tableId)
    {
        try {
            
            $this->setSql("SELECT * FROM `" . $this->table . "` WHERE table_id = $tableId");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateByTableId($data, $id)
    {
        try {
            
            $this->setSql("UPDATE `{$this->table}` SET table_number = :tableNumber, status = :status WHERE table_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->bindValue(':tableNumber', $data['tableNumber']);
            $this->stmt->bindValue(':status', $data['status']);

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateByField($data, string $field, $userId)
    {

    }

    public function delete($id)
    {
        try {
            
            $this->setSql("DELETE FROM `{$this->table}` WHERE table_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Getters e Setters
    public function setSql($sql) {
        $this->sql = $sql;
    }

    public function getSql() {
        return $this->sql;
    }
}