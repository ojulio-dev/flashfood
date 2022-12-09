<?php

namespace Model;

use Classes\Database;
use PDO;
use PDOException;

class Ingredient extends Database {

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'ingredient';
    }
    
    public function create($data)
    {

        try {
            
            $this->setSql("INSERT INTO " . $this->table . " (name, price, slug, status) VALUES ('" . $data['name'] . "', '" . $data['price'] . "', '" . $data['slug'] . "', " . $data['status'] . ")");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {
                return true;

            } else {
                return false;

            }

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

            if ($this->stmt->rowCount()) {
                
                return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                
                return false;
            }

        } catch (PDOException $e) {

            return $e->getMessage();
        }
    }

    public function readById($id)
    {
        try {

            $this->setSql("SELECT * FROM " . $this->table . " WHERE ingredient_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                return $this->stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readBySlug($slug)
    {
        try {

            $this->setSql("SELECT * FROM " . $this->table . " WHERE slug = '$slug'");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {

                return true;
            } else {

                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readByProductSlug($slug)
    {
        try {

            $this->setSql("");

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

    public function countIngredients($id)
    {
        try {

            $this->setSql("SELECT * FROM " . $this->table . " WHERE ingredient_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {
                return count($this->stmt->fetchAll(PDO::FETCH_ASSOC));
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function updateById($id, $data)
    {

        try {
            
            $this->setSql("UPDATE " . $this->table ." SET name = '" . $data['name'] . "', price = '" . $data['price'] . "', slug = '" . $data['slug'] . "', status = " . $data['status'] . " WHERE ingredient_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return true;

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function updateByField($data, string $field, $ingredientId): bool
    {
        try {
            $this->setSql(
            "UPDATE " . $this->table . "
                SET $field = '$data'
            WHERE
                ingredient_id = $ingredientId
            ");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {

            $this->setSql("DELETE FROM " . $this->table . " WHERE ingredient_Id = {$id}");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {

                return true;

            } else {
                return false;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
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