<?php

namespace Model;

use Classes\Database;
use PDO;
use PDOException;

class Product extends Database{

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'product';
    }

    private function createFile($file, $id) {

        $extension = strtolower( substr($file['name'], -4) );

        $newName = $id . $extension;

        $destiny = __DIR__ . '/../dashboard/assets/images/products/' . $newName;

        if (file_exists($destiny)) unlink($destiny);

        move_uploaded_file($file['tmp_name'], $destiny);

        return "$newName";
    }

    public function create($data)
    {
        try {

            $this->setSql("INSERT INTO " . $this->table . "(category_id, name, description, special_price, price, slug, status) VALUES (" . $data['category_id'] . ", '" . $data['name'] . "', '" . $data['description'] . "', '" . $data['special_price'] ."', '" . $data['price'] ."', '" . $data['slug'] . "', " . $data['status'] . ")");

            $this->stmt = $this->conn()->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                if (file_exists($_FILES['banner']['tmp_name'])) {
                    $id = $this->conn->query("SELECT product_id FROM " . $this->table . " WHERE slug = '" . $data['slug'] . "'")->fetch(PDO::FETCH_ASSOC);

                    $destiny = $this->createFile($_FILES['banner'], $id['product_id']);

                    $this->updateByField($destiny, 'banner', $id['product_id']);
                }

                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function read()
    {
        try {

            $this->setSql("SELECT P.*, C.category_id, C.status as category_status, C.name as category FROM product P INNER JOIN product_category C ON P.category_id = C.category_id WHERE C.status = 1 ORDER BY C.name DESC");

            $this->stmt = $this->conn()->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function readById($id)
    {
        try {

            $this->setSql("SELECT * FROM " . $this->table . " WHERE product_id = $id");

            $this->stmt = $this->conn()->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                return $this->stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function readBySlug($slug)
    {
        try {

            $this->setSql("SELECT * FROM " . $this->table . " WHERE slug = '{$slug}'");

            $this->stmt = $this->conn()->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                return $this->stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateById($id, $data)
    {
        try {

            $this->setSql("UPDATE " . $this->table . " SET category_id = " . $data['category_id'] . ", name = '" . $data['name'] . "', description = '" . $data['description'] . "', special_price = " . $data['special_price'] . ", price = " . $data['price'] .", status = " . $data['status'] . ", slug = '" . $data['slug'] . "' WHERE product_id = $id");

            $this->stmt = $this->conn()->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount() || file_exists($_FILES['banner']['tmp_name'])) {
                if (file_exists($_FILES['banner']['tmp_name'])) {
                    $id = $this->conn->query("SELECT product_id FROM " . $this->table . " WHERE slug = '" . $data['slug'] . "'")->fetch(PDO::FETCH_ASSOC);

                    $destiny = $this->createFile($_FILES['banner'], $id['product_id']);

                    $this->updateByField($destiny, 'banner', $id['product_id']);
                }
                
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateByField($data, string $field, $productId): bool
    {
        try {
            $this->setSql(
            "UPDATE " . $this->table . "
                SET $field = '$data'
            WHERE
                product_id = $productId
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

    public function deleteStatus($id)
    {
        try {
            $this->setSql("UPDATE " . $this->table . " SET status = 0 WHERE product_id = {$id}");

            $this->stmt = $this->conn()->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {

            $banner = $this->conn->query("SELECT banner FROM " . $this->table . " WHERE product_id = {$id}")->fetch(PDO::FETCH_ASSOC);

            $this->setSql("DELETE FROM " . $this->table ." WHERE product_id = {$id}");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {
                $this->deleteFile($banner['banner']);

                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function deleteFile($banner)
    {
        $destiny = __DIR__ . '/../dashboard/assets/images/products/' . $banner;

        if (file_exists($destiny)) {
            unlink($destiny);   
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