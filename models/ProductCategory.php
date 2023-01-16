<?php

namespace Model;

use Classes\Database;
use PDO;
use PDOException;

class ProductCategory extends Database{
    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'product_category';
    }

    private function createFile($file, $id) {

        $extension = strtolower( substr($file['name'], -4) );

        $newName = $id . $extension;

        $destiny = __DIR__ . '/../assets/images/categories/' . $newName;

        if (file_exists($destiny)) unlink($destiny);

        move_uploaded_file($file['tmp_name'], $destiny);

        return "$newName";
    }

    public function create($data)
    {
        try {

            $this->setSql("INSERT INTO " . $this->table . " (name, slug, status) VALUES ('" . $data['name'] . "', '" . $data['slug'] . "', " . $data['status'] . ")");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {

                if (file_exists($data['banner']['tmp_name'])) {
                    $id = $this->conn->query("SELECT category_id FROM " . $this->table . " WHERE slug = '" . $data['slug'] . "'")->fetch(PDO::FETCH_ASSOC);

                    $destiny = $this->createFile($data['banner'], $id['category_id']);

                    $this->updateByField($destiny, 'banner', $id['category_id']);
                }

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

            $this->setSql("SELECT * FROM " . $this->table . " ORDER BY category_id");

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

    public function readWithCount()
    {
        try {

            $this->setSql("SELECT pc.*, (SELECT COUNT(p.name) FROM product as p WHERE p.category_id = pc.category_id) AS 'count' FROM " . $this->table . " as pc ORDER BY pc.status DESC");

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

            return $this->stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function readBySlug($slug)
    {
        try {

            $this->setSql("SELECT * FROM " . $this->table . " WHERE slug = '{$slug}'");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            return $this->stmt->fetch(PDO::FETCH_ASSOC);

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
            WHERE pc.category_id = $id ORDER BY status DESC");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readByCategoryStatus($id)
    {
        try {
            $this->setSql("SELECT po.* FROM
                {$this->table} pc
            INNER JOIN product po on po.category_id = pc.category_id
            WHERE pc.category_id = $id AND po.status = 1 ORDER BY status DESC");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readBySearch($id, $search)
    {
        try {
            $this->setSql("SELECT po.* FROM
                {$this->table} pc
            INNER JOIN product po on po.category_id = pc.category_id
            WHERE pc.category_id = $id AND po.name LIKE '$search%' ORDER BY status DESC");

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

    public function updateByField($data, string $field, $categoryId): bool
    {
        try {
            $this->setSql(
            "UPDATE " . $this->table . "
                SET $field = '$data'
            WHERE
                category_id = $categoryId
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

    public function updateById($id, $data)
    {
        try {

            $this->setSql("UPDATE " . $this->table . " SET name = '" . $data['name'] . "', status = " . $data['status'] . ", slug = '" . $data['slug'] . "' WHERE category_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if (!empty($data['banner']['tmp_name'])) {

                $id = $this->conn->query("SELECT category_id FROM " . $this->table . " WHERE slug = '" . $data['slug'] . "'")->fetch(PDO::FETCH_ASSOC);

                $destiny = $this->createFile($_FILES['banner'], $id['category_id']);

                $this->updateByField($destiny, 'banner', $id['category_id']);

            }

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

    public function delete($id)
    {
        try {

            $banner = $this->conn->query("SELECT banner FROM " . $this->table . " WHERE category_id = {$id}")->fetch(PDO::FETCH_ASSOC);

            $this->setSql("DELETE FROM product_category WHERE category_id = {$id}");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if ($this->stmt->rowCount()) {

                $this->stmt = $this->conn->query("DELETE FROM product WHERE category_id = {$id}");

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
        $destiny = __DIR__ . '/../assets/images/categories/' . $banner;

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