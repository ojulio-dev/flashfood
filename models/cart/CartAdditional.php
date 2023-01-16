<?php

namespace Model\Cart;

use Classes\Database;
use PDO;
use PDOException;

class CartAdditional extends Database {

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'cart_additional';
    }

    public function create($cartId, $additionals)
    {

        $values = "";

        foreach($additionals as $additional) {
            $values .= "({$cartId}, " . $additional['id'] . ", " . $additional['quantity'] . "),";
        }

        $values = substr($values, 0, -1);

        try {
            
            $this->setSql("INSERT INTO " . $this->table . " (cart_id, additional_id, quantity) VALUES {$values}");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function readByCartId($cartId)
    {

        try {
            
            $this->setSql("SELECT I.name, I.price, CA.* FROM " . $this->table . " CA INNER JOIN additional as A on CA.additional_id = A.additional_id INNER JOIN ingredient as I on I.ingredient_id = A.ingredient_id WHERE CA.cart_id = $cartId");

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