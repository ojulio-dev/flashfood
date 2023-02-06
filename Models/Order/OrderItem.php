<?php

namespace Model\Order;

use Classes\Database;
use Model\Order\OrderItemAdditional;
use Model\Cart\CartAdditional;

use PDO;
use PDOException;

class OrderItem extends Database {

    private $stmt, $sql, $conn, $table;
    private $orderItemAdditional;
    private $cartAdditional;

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

            foreach($orderItems as $item) {

                $this->setSql("INSERT INTO " . $this->table . " (order_id, product_id, category_name, product_name, product_banner, product_description, product_price, product_special_price, quantity, note)
                VALUES ($orderId, :product_id, :category_name, :product_name, :product_banner, :product_description, :product_price, :product_special_price, :quantity, :note)");

                $this->stmt = $this->conn->prepare($this->getSql());

                $this->stmt->bindValue(':product_id', $item['product_id']);
                $this->stmt->bindValue(':category_name', $item['category_name']);
                $this->stmt->bindValue(':product_name', $item['name']);
                $this->stmt->bindValue(':product_banner', $item['banner']);
                $this->stmt->bindValue(':product_description', $item['description']);
                $this->stmt->bindValue(':product_price', $item['price']);
                $this->stmt->bindValue(':product_special_price', $item['special_price']);
                $this->stmt->bindValue(':quantity', $item['quantity']);
                $this->stmt->bindValue(':note', $item['note']);

                $this->stmt->execute();

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
            
            $this->setSql("SELECT SUM(quantity) as quantity FROM " . $this->table . " WHERE order_id = $orderId");

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
            
            $this->setSql("SELECT * FROM " . $this->table . " WHERE order_id = $orderId");

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