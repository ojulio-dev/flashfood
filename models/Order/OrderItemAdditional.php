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
                $values .= "($orderId, $orderItemId, " . $additional['additional_id'] . ", '" . $additional['name'] . "', " . $additional['price'] . ", " . $additional['quantity'] . "),";
            }

            $values = substr($values, 0, -1);

            $this->setSql("INSERT INTO " . $this->table . " (order_id, order_item_id, additional_id, additional_name, additional_price, quantity) VALUES $values");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function readByItemId(string $itemId)
    {

        try {
            
            $this->setSql("SELECT I.name, I.price, OA.quantity FROM order_item_additional OA 
                INNER JOIN `order` AS O ON O.order_id = OA.order_id 
                INNER JOIN additional AS A ON A.additional_id = OA.additional_id 
                INNER JOIN ingredient AS I ON I.ingredient_id = A.ingredient_id
                INNER JOIN order_item AS OI on OA.order_item_id = OI.order_item_id
            WHERE OI.order_item_id = $itemId");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function readByItemsIds(array $itemsIds)
    {

        try {

            $values = "";

            foreach($itemsIds as $itemId) {
                $values .= "$itemId,";
            }

            $values = substr($values, 0, -1);
            
            $this->setSql("SELECT * FROM {$this->table} WHERE order_item_id IN ($values)");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

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