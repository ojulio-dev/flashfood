<?php

namespace Model\Order;

use Classes\Database;
use Model\Order\OrderItem;
use Model\Order\OrderItemAdditional;

use PDO;
use PDOException;

class Order extends Database {

    private $stmt, $sql, $conn, $table;
    private $orderItem;
    private $orderItemAdditional;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'order';

        $this->orderItem = new OrderItem();

        $this->orderItemAdditional = new OrderItemAdditional();
    }

    /**
     * Create an Order
     *
     * @param array $cartItems
     * @return int
    */
    public function create($orderItems, $tableId, $userId)
    {
        $this->setSql("SELECT MAX(order_number) as order_number FROM `order`");

        $this->stmt = $this->conn->prepare($this->getSql());

        $this->stmt->execute();

        $orderNumber = $this->stmt->fetch(PDO::FETCH_ASSOC)['order_number'];

        $orderNumber = str_pad(((int) $orderNumber + 3), 6, '0', STR_PAD_LEFT);

        $this->setSql("INSERT INTO `" . $this->table . "` (order_number, `table_number`, user_id) VALUES ('$orderNumber', $tableId, $userId)");

        $this->stmt = $this->conn->query($this->getSql());

        $orderId = $this->conn->lastInsertId();

        $orderItemId = $this->orderItem->create($orderId, $orderItems);

        return $this->stmt->rowCount();

    }

    public function read()
    {

        try {
            
            $this->setSql("SELECT O.*, S.name as status_name, S.color as status_color FROM `" . $this->table . "` O INNER JOIN order_status as S on S.status_id = O.status_id ORDER BY order_number DESC");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function readByStatusId($statusId)
    {

        try {
            
            $this->setSql("SELECT O.*, S.name as status_name, S.color as status_color FROM `" . $this->table . "` O INNER JOIN order_status as S on S.status_id = O.status_id WHERE O.status_id = $statusId");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function readByOrderNumber($orderNumber)
    {

        try {
            
            $this->setSql("SELECT O.order_id, I.*, O.order_number, O.table_number, O.status_id, O.created_at FROM `" . $this->table . "` O INNER JOIN order_item AS I ON I.order_id = O.order_id WHERE order_number = $orderNumber");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            $products = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

            $itemsIds = [];

            foreach($products as $product) {
                $itemsIds[] = $product['order_item_id'];
            }

            $additionals = $this->orderItemAdditional->readByItemsIds($itemsIds);

            foreach($products as $productKey => $product) {

                $itemId = $product['order_item_id'];

                $products[$productKey]['additionals'] = [];
                
                foreach($additionals as $additionalKey => $additional) {
                    
                    if ($itemId == $additional['order_item_id']) {
                        $products[$productKey]['additionals'][] = $additionals[$additionalKey];
                    }

                }
            }

            return $products;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function finishOrder($orderNumber)
    {
        try {
            
            $this->setSql("UPDATE `" . $this->table . "` SET status_id = 3 WHERE order_number = '$orderNumber'");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function cancelOrder($orderNumber)
    {
        try {
            
            $this->setSql("UPDATE `" . $this->table . "` SET status_id = 4 WHERE order_number = '$orderNumber'");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function processingOrder($orderNumber)
    {
        try {
            
            $this->setSql("UPDATE `" . $this->table . "` SET status_id = 2 WHERE order_number = '$orderNumber'");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

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