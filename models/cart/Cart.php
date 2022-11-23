<?php

namespace Model\Cart;

use Classes\Database;
use PDO;
use PDOException;

class Cart extends Database {

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'cart';
    }

    public function create($userId, $productId)
    {
        try {
            
            $this->setSql("INSERT INTO " . $this->table . " (user_id, product_Id) VALUES ({$userId}, $productId)");

            $this->stmt = $this->conn()->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();
            
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function read()
    {
        try {
            
            $this->setSql("SELECT P.*, C.quantity FROM " . $this->table . " as C INNER JOIN product P on C.product_id = P.product_id WHERE C.status = 1");

            $this->stmt = $this->conn()->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {
                return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return [];
            }

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function readByProductId($id)
    {
        try {
            
            $this->setSql("SELECT product_id FROM " . $this->table . " WHERE product_id = {$id}");

            $this->stmt = $this->conn()->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function update()
    {

    }

    public function delete()
    {
        
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