<?php

namespace Model\Order;

use Classes\Database;

use PDO;
use PDOException;

class OrderStatus extends Database {

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'order_status';
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

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
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