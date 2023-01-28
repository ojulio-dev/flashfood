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

    public function create($userId, $productId, $productQuantity = 1)
    {
        try {
            
            $this->setSql("INSERT INTO " . $this->table . " (user_id, product_Id, quantity) VALUES ({$userId}, $productId, $productQuantity)");

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
            
            $this->setSql("SELECT P.*, PO.name as category_name, C.quantity, C.cart_id FROM " . $this->table . " as C INNER JOIN product P on C.product_id = P.product_id INNER JOIN product_category PO on P.category_id = PO.category_id WHERE C.status = 1 AND C.user_id = $userId");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            $products =  $this->stmt->fetchAll(PDO::FETCH_ASSOC);

            for ($i = 0; $i < count($products); $i++) {
                $products[$i]['additionals'] = $this->cartAdditional->readByCartId($products[$i]['cart_id']);
            }

            return $products;

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