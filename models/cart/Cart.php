<?php

namespace Model\Cart;

use Classes\Database;
use PDO;
use PDOException;

use Model\Cart\CarAdditional;

class Cart extends Database {

    private $stmt, $sql, $conn, $table;
    private $cartAdditional;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'cart';

        $this->cartAdditional = new CartAdditional();
    }

    public function create($userId, $productId, $productQuantity = 1, $note = null)
    {
        try {
            
            $this->setSql("INSERT INTO " . $this->table . " (user_id, product_Id, quantity, note) VALUES ({$userId}, $productId, $productQuantity, '$note')");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->conn->lastInsertId();
            
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function read($userId)
    {
        try {

            $cart = new Cart();
            
            $this->setSql("SELECT P.*, PO.name as category_name, C.quantity, C.cart_id, C.note FROM " . $this->table . " as C INNER JOIN product P on C.product_id = P.product_id INNER JOIN product_category PO on P.category_id = PO.category_id WHERE C.status = 1 AND C.user_id = $userId ORDER BY cart_id DESC");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            $products =  $this->stmt->fetchAll(PDO::FETCH_ASSOC);

            for ($i = 0; $i < count($products); $i++) {
                $products[$i]['additionals'] = $this->cartAdditional->readByCartId($products[$i]['cart_id']);

                $products[$i]['additionalsQuantity'] = $cart->readAdditionalsQuantity($_SESSION['flashfood']['user']['user_id'], $products[$i]['cart_id']);
            }

            return $products;

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function readAdditionalsQuantity($userId, $cartId)
    {
        try {
            
            $this->setSql("SELECT SUM(CA.quantity) AS quantity FROM {$this->table} C INNER JOIN cart_additional as CA on CA.cart_id = C.cart_id WHERE C.status = 1 AND C.user_id = 1 AND C.cart_id = $cartId");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetch(PDO::FETCH_ASSOC)['quantity'] ?? 0;

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function readByProductId($userId, $productId)
    {
        try {
            
            $this->setSql("SELECT * FROM " . $this->table . " WHERE user_id = $userId AND product_id = {$productId} AND status = 1");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {
                return $this->stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function readTotalPrice($userId)
    {
        try {

            $totalPrice = 0;
            
            $this->setSql("SELECT P.price, P.special_price, C.quantity, C.cart_id FROM " . $this->table . " as C INNER JOIN product P on C.product_id = P.product_id WHERE C.status = 1 AND C.user_id = $userId");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            $productsCart = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($productsCart as $productCart) {

                $totalPrice += ($productCart['special_price'] ?? $productCart['price']) * $productCart['quantity'];

                $totalPrice += $this->cartAdditional->readTotalPrice($productCart['cart_id']);

            }

            return $totalPrice;

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }
    
    public function changeQuantity($userId, $quantity, $cartId)
    {

        try {

            $this->setSql("UPDATE " . $this->table . " SET quantity = {$quantity} WHERE user_id = $userId AND cart_id = {$cartId}");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function changeStatus($userId)
    {

        try {

            $this->setSql("UPDATE cart_additional SET status = 0 WHERE status = 1");

            $this->conn->query($this->getSql());
            
            $this->setSql("UPDATE " . $this->table . " SET status = 0 WHERE user_id = $userId AND status = 1");

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

    public function deleteByCartId($userId, $cartId)
    {
        
        try {
            
            $this->setSql("DELETE FROM " . $this->table . " WHERE cart_id = {$cartId} AND user_id = {$userId}");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function delete($userId) {

        try {
            
            $this->setSql("DELETE FROM " . $this->table . " WHERE user_id = {$userId} AND status = 1");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

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