<?php

namespace Model\Order;

use Classes\Database;
use Model\Order\OrderItem;
use Model\Order\OrderItemAdditional;

use PDO;
use PDOException;
use DateTime;

date_default_timezone_set('America/Sao_Paulo');

ob_start();

class Order extends Database {

    private $stmt, $sql, $conn, $table;
    private $orderItem;
    private $orderItemAdditional;
    private $orderStatus;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'order';

        $this->orderItem = new OrderItem();

        $this->orderItemAdditional = new OrderItemAdditional();

        $this->orderStatus = new OrderStatus();
    }

    /**
     * Create an Order
     *
     * @param array $cartItems
     * @return int
    */
    public function create($orderItems, $tableId, $userId)
    {
        $dateTime = new DateTime('now');

        $this->setSql("SELECT MAX(order_number) as order_number FROM `order`");

        $this->stmt = $this->conn->prepare($this->getSql());

        $this->stmt->execute();

        $orderNumber = $this->stmt->fetch(PDO::FETCH_ASSOC)['order_number'];

        $orderNumber = str_pad(((int) $orderNumber + 3), 6, '0', STR_PAD_LEFT);

        $now = $dateTime->format('Y-m-d H:i:s');

        $this->setSql("INSERT INTO `" . $this->table . "` (order_number, `table_number`, user_id, created_at) VALUES ('$orderNumber', $tableId, $userId, '$now')");

        $this->stmt = $this->conn->query($this->getSql());

        $orderId = $this->conn->lastInsertId();

        $orderItemId = $this->orderItem->create($orderId, $orderItems);

        return $orderNumber;

    }

    public function read()
    {

        try {
            
            $this->setSql("SELECT O.*, S.name as status_name, S.color as status_color, S.position as status_position, U.name as user_name FROM `" . $this->table . "` O INNER JOIN order_status as S on S.status_id = O.status_id INNER JOIN user as U on O.user_id = U.user_id ORDER BY order_number DESC");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            $orders = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

            $dateTime = new DateTime('now');

            for ($i = 0; $i < count($orders); $i++) {

                $dataDifference = $dateTime->diff(new DateTime($orders[$i]['created_at']));

                $timeSpent = str_pad($dataDifference->s, 2, 0, STR_PAD_LEFT);    

                $timeTitle = ' segundos';

                if ($dataDifference->i) {
                    $timeSpent = str_pad($dataDifference->i, 2, 0, STR_PAD_LEFT) . ':' . str_pad($dataDifference->s, 2, 0, STR_PAD_LEFT);
                    $timeTitle = ' minutos';
                }

                if ($dataDifference->h) {
                    $timeSpent = str_pad($dataDifference->h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($dataDifference->i, 2, 0, STR_PAD_LEFT);
                    $timeTitle = ' horas';
                }

                if ($dataDifference->d) {
                    $timeSpent = str_pad($dataDifference->d, 2, 0, STR_PAD_LEFT);
                    $timeTitle = $dataDifference->d > 1 ? ' dias' : ' dia';
                }

                $orders[$i]['timeSpent'] = $timeSpent . $timeTitle;

                $orders[$i]['quantity'] = 0;

                $orders[$i]['quantity'] = $this->orderItem->readProductsQuantity($orders[$i]['order_id']);

                $orders[$i]['order_items'] = $this->readByOrderId($orders[$i]['order_id']);
            }

            return $orders;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function readKitchen()
    {

        try {
            
            $this->setSql("SELECT O.*, S.name as status_name, S.color as status_color, S.position as status_position, U.name as user_name FROM `" . $this->table . "` O INNER JOIN order_status as S on S.status_id = O.status_id INNER JOIN user as U on O.user_id = U.user_id WHERE O.status_id IN (1, 2) ORDER BY order_number DESC");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            $orders = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

            $dateTime = new DateTime('now');

            for ($i = 0; $i < count($orders); $i++) {

                $dataDifference = $dateTime->diff(new DateTime($orders[$i]['created_at']));

                $timeSpent = str_pad($dataDifference->s, 2, 0, STR_PAD_LEFT);    

                $timeTitle = ' segundos';

                if ($dataDifference->i) {
                    $timeSpent = str_pad($dataDifference->i, 2, 0, STR_PAD_LEFT) . ':' . str_pad($dataDifference->s, 2, 0, STR_PAD_LEFT);
                    $timeTitle = ' minutos';
                }

                if ($dataDifference->h) {
                    $timeSpent = str_pad($dataDifference->h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($dataDifference->i, 2, 0, STR_PAD_LEFT);
                    $timeTitle = ' horas';
                }

                if ($dataDifference->d) {
                    $timeSpent = str_pad($dataDifference->d, 2, 0, STR_PAD_LEFT);
                    $timeTitle = $dataDifference->d > 1 ? ' dias' : ' dia';
                }

                $orders[$i]['timeSpent'] = $timeSpent . $timeTitle;

                $orders[$i]['quantity'] = 0;

                $orders[$i]['quantity'] = $this->orderItem->readProductsQuantity($orders[$i]['order_id']);

                $orders[$i]['order_items'] = $this->readByOrderId($orders[$i]['order_id']);
            }

            return $orders;

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
            
            $this->setSql("SELECT O.order_id, I.*, O.order_number, O.table_number, O.status_id, O.created_at FROM `" . $this->table . "` O INNER JOIN order_item AS I ON I.order_id = O.order_id WHERE O.order_number = $orderNumber");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if (!$this->stmt->rowCount()) {

                return [];
                exit();
            }

            $products = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                
            foreach($products as $key => $product) {
                $products[$key]['product_banner'] = file_exists(__DIR__ . '/../../assets/images/products/' . $products[$key]['product_banner']) 
                    ?
                SERVER_HOST . '/assets/images/products/' . $products[$key]['product_banner']
                    : 
                SERVER_HOST . '/assets/images/system/placeholder.png';
            }

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

    public function readByOrderId($orderId)
    {

        try {
            
            $this->setSql("SELECT O.order_id, I.*, O.order_number, O.table_number, O.status_id, O.created_at FROM `" . $this->table . "` O INNER JOIN order_item AS I ON I.order_id = O.order_id WHERE O.order_id = $orderId");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if (!$this->stmt->rowCount()) {

                return [];
                exit();
            }

            $products = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                
            foreach($products as $key => $product) {
                $products[$key]['product_banner'] = file_exists(__DIR__ . '/../../assets/images/products/' . $products[$key]['product_banner']) 
                    ?
                SERVER_HOST . '/assets/images/products/' . $products[$key]['product_banner']
                    : 
                SERVER_HOST . '/assets/images/system/placeholder.png';
            }

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

    public function readByUserId($userId)
    {

        try {
            
            $this->setSql("SELECT O.*, S.name as status_name, S.color as status_color, S.position as status_position, U.name as user_name FROM `" . $this->table . "` O INNER JOIN order_status as S on S.status_id = O.status_id INNER JOIN user as U on O.user_id = U.user_id WHERE O.user_id = $userId ORDER BY order_number DESC");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            $orders = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

            $dateTime = new DateTime('now');

            for ($i = 0; $i < count($orders); $i++) {

                $dataDifference = $dateTime->diff(new DateTime($orders[$i]['created_at']));

                $timeSpent = str_pad($dataDifference->s, 2, 0, STR_PAD_LEFT);    

                $timeTitle = ' segundos';

                if ($dataDifference->i) {
                    $timeSpent = str_pad($dataDifference->i, 2, 0, STR_PAD_LEFT) . ':' . str_pad($dataDifference->s, 2, 0, STR_PAD_LEFT);
                    $timeTitle = ' minutos';
                }

                if ($dataDifference->h) {
                    $timeSpent = str_pad($dataDifference->h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($dataDifference->i, 2, 0, STR_PAD_LEFT);
                    $timeTitle = ' horas';
                }

                if ($dataDifference->d) {
                    $timeSpent = str_pad($dataDifference->d, 2, 0, STR_PAD_LEFT);
                    $timeTitle = $dataDifference->d > 1 ? ' dias' : ' dia';
                }

                $orders[$i]['timeSpent'] = $timeSpent . $timeTitle;

                $orders[$i]['quantity'] = 0;

                $orders[$i]['quantity'] = $this->orderItem->readProductsQuantity($orders[$i]['order_id']);

                $orders[$i]['order_items'] = $this->readByOrderId($orders[$i]['order_id']);
            }

            return $orders;

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

    public function changeStatus($orderId, $statusId) {

        try {
            
            $this->setSql("UPDATE `{$this->table}` SET status_id = $statusId WHERE order_id = $orderId");

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