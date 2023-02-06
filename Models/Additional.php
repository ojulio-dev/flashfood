<?php

namespace Model;

use Classes\Database;
use PDO;
use PDOException;

class Additional extends Database {

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'additional';
    }
    
    public function create($ingredientIds, $productId = null)
    {

        $productId = $productId ?? $this->lastProductId();

        $values = "";

        foreach($ingredientIds as $id) {
            $values .= "({$id}, {$productId}),";
        }

        $values = substr($values, 0, -1);

        try {
            
            $this->setSql("INSERT INTO " . $this->table . " (ingredient_id, product_id) VALUES {$values}");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {

            return $e->getMessage();
        }
    }

    public function read()
    {
        try {
            
            $this->setSql("SELECT * FROM " . $this->table . "");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function readByProductId($id)
    {
        try {
            
            $this->setSql("SELECT * FROM " . $this->table . " WHERE product_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {

                return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                
                return [];
            }
            
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function readIngredientsById($id)
    {
        try {

            $this->setSql("SELECT I.*, A.additional_id FROM " . $this->table . " A INNER JOIN ingredient I on I.ingredient_id = A.ingredient_id INNER JOIN product P on P.product_id = A.product_id WHERE P.product_id = '{$id}' AND A.status = 1 AND I.status = 1");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {

                return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return [];
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readIngredientsBySlug($slug)
    {
        try {

            $this->setSql("SELECT I.* FROM " . $this->table . " A INNER JOIN ingredient I on I.ingredient_id = A.ingredient_id INNER JOIN product P on P.product_id = A.product_id WHERE P.slug = '{$slug}' AND A.status = 1");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {

                return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function lastProductId()
    {
        try {
            
            $sql = "SELECT MAX(product_id) as id FROM product";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            $id = $stmt->fetch()['id'];

            return $id;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function delete($productId)
    {
        try {
            
            $this->setSql("DELETE FROM " . $this->table . " WHERE product_id = {$productId}");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            throw $e->getMessage();
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