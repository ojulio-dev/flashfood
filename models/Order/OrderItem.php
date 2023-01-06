<?php

namespace Model\Order;

use Classes\Database;
use Model\Order\OrderItemAdditional;
use Model\Cart\CartAdditional;

use PDO;
use PDOException;

class OrderItem extends Database {

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'order_item';

        $this->orderItemAdditional = new OrderItemAdditional();

        $this->cartAdditional = new CartAdditional();
    }

    public function create($orderId, $orderItems)
    {

        try {
            
            // $items = "";

            // foreach($orderItems as $item) {
            //     $items .= "({$orderId}, " . $item['product_id'] . ", " . $item['quantity'] . "),";
            // }

            // $items = substr($items, 0, -1);

            foreach($orderItems as $item) {

                $this->setSql("INSERT INTO " . $this->table . " (order_id, product_id, quantity) VALUES ($orderId, " . $item['product_id'] . ", " . $item['quantity'] . ")");

                $this->stmt = $this->conn->query($this->getSql());

                $orderItemId = $this->conn->lastInsertId();

                $additionals = $this->cartAdditional->readByCartId($item['cart_id']);

                if ($additionals) {
                    $this->orderItemAdditional->create($orderId, $orderItemId, $additionals);
                }

            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function readProductsQuantity($orderId)
    {

        try {
            
            $this->setSql("SELECT SUM(quantity) as quantity FROM " . $this->table . " WHERE order_id = $orderId AND status = 1");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetch(PDO::FETCH_ASSOC)['quantity'];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function readByOrderId($orderId)
    {

        try {
            
            $this->setSql("SELECT * FROM " . $this->table . " WHERE order_id = $orderId AND status = 1");

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