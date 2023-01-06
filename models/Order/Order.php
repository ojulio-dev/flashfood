<?php

namespace Model\Order;

use Classes\Database;
use Model\Order\OrderItem;

use PDO;
use PDOException;

class Order extends Database {

    private $stmt, $sql, $conn, $table;
    private $orderItem;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'order';

        $this->orderItem = new OrderItem();
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
            
            $this->setSql("SELECT * FROM `" . $this->table . "` WHERE status = 1");

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
            
            $this->setSql("SELECT O.order_id, I.order_item_id, O.order_number, O.table_number, P.name, P.banner, P.description, P.price, P.special_price, P.slug, O.created_at, I.quantity, C.name as category FROM `" . $this->table . "` O INNER JOIN order_item AS I ON I.order_id = O.order_id INNER JOIN product AS P ON I.product_id = P.product_id INNER JOIN product_category as C on P.category_id = C.category_id WHERE order_number = $orderNumber");

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