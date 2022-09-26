<?php

namespace Dashboard\Model;

use Dashboard\Classes\Database;
use PDO;
use PDOException;

class ProductCategory extends Database{
    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'product_category';
    }

    public function create($data)
    {
        try {

            $this->setSql("INSERT INTO " . $this->table . " (name, slug, status) VALUES ('" . $data['name'] . "', '" . $data['slug'] . "', " . $data['status'] . ")");

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

            $this->setSql("SELECT * FROM " . $this->table . " WHERE status = 1");

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

    public function readAll()
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

            $this->setSql("SELECT * FROM " . $this->table . " WHERE category_id = {$id}");

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

    public function readByCategory($id)
    {
        try {
            $this->setSql("SELECT po.* FROM
                {$this->table} pc
            INNER JOIN product po on po.category_id = pc.category_id
            WHERE pc.category_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function countProducts($id)
    {
        try {

            $this->setSql("SELECT * FROM product WHERE category_id = $id");

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

    public function update($data)
    {
        try {

            $this->setSql("UPDATE " . $this->table ." SET name = '" . $data['name'] . "', slug = '" . $data['slug'] . "', status = " . $data['status'] . " WHERE category_id = " . $data['category_id'] . "");

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

    public function deleteById($id)
    {
        try {

            $this->setSql("UPDATE " . $this->table ." SET status = 0 WHERE category_id = {$id}");

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