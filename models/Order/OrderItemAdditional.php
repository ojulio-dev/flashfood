<?php

namespace Model\Order;

use Classes\Database;

use PDO;
use PDOException;

class OrderItemAdditional extends Database {

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'order_item_additional';
    }

    public function create($orderId, $orderItemId, $additionals): int
    {

        try {

            $values = "";

            foreach($additionals as $additional) {
                $values .= "($orderId, $orderItemId, " . $additional['additional_id'] . "),";
            }

            $values = substr($values, 0, -1);

            $this->setSql("INSERT INTO " . $this->table . " (order_id, order_item_id, additional_id) VALUES $values");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function read()
    {

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