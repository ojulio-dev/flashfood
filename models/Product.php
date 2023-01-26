<?php

namespace Model;

use Classes\Database;
use Model\Additional;

use PDO;
use PDOException;

class Product extends Database {

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'product';
    }

    private function createFile($file, $id) {

        $extension = strtolower( substr($file['name'], -4) );

        $newName = $id . $extension;

        $destiny = __DIR__ . '/../assets/images/products/' . $newName;

        if (file_exists($destiny)) unlink($destiny);

        move_uploaded_file($file['tmp_name'], $destiny);

        return "$newName";
    }

    public function create($data)
    {
        try {

            $specialPrice = isset($data['special_price']) ? $data['special_price'] : 'NULL';

            $this->setSql("INSERT INTO " . $this->table . "(category_id, name, description, special_price, price, slug, status) VALUES (" . $data['category_id'] . ", '" . $data['name'] . "', '" . $data['description'] . "', $specialPrice, '" . $data['price'] ."', '" . $data['slug'] . "', " . $data['status'] . ")");

            $this->stmt = $this->conn->prepare($this->getSql());

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

            $this->setSql("SELECT P.*, C.category_id, C.status as category_status, C.name as category FROM product P INNER JOIN product_category C ON P.category_id = C.category_id WHERE C.status = 1 AND P.status = 1 ORDER BY P.product_id DESC");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {

                $products =  $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach($products as $key => $product) {
                    $products[$key]['banner'] = file_exists(__DIR__ . '/../assets/images/products/' . $products[$key]['banner']) 
                        ?
                    SERVER_HOST . '/assets/images/products/' . $products[$key]['banner']
                        : 
                    SERVER_HOST . '/assets/images/system/placeholder.png';
                }

                return $products;

            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readRecents()
    {
        try {

            $this->setSql("SELECT P.*, C.category_id, C.status as category_status, C.name as category FROM product P INNER JOIN product_category C ON P.category_id = C.category_id WHERE C.status = 1 AND P.status = 1 ORDER BY P.product_id DESC LIMIT 8");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {

                $products =  $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach($products as $key => $product) {
                    $products[$key]['banner'] = file_exists(__DIR__ . '/../assets/images/products/' . $products[$key]['banner']) 
                        ?
                    SERVER_HOST . '/assets/images/products/' . $products[$key]['banner']
                        : 
                    SERVER_HOST . '/assets/images/system/placeholder.png';
                }

                return $products;

            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readAdmin()
    {
        try {

            $this->setSql("SELECT P.*, C.category_id, C.status as category_status, C.name as category FROM product P INNER JOIN product_category C ON P.category_id = C.category_id WHERE C.status = 1 ORDER BY P.product_id DESC");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {

                $products =  $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach($products as $key => $product) {
                    $products[$key]['banner'] = file_exists(__DIR__ . '/../assets/images/products/' . $products[$key]['banner']) 
                        ?
                    SERVER_HOST . '/assets/images/products/' . $products[$key]['banner']
                        : 
                    SERVER_HOST . '/assets/images/system/placeholder.png';
                }

                return $products;

            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readById($id)
    {

        $additional = new Additional;

        try {

            $this->setSql("SELECT * FROM " . $this->table . " WHERE product_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                
                $product = [];

                $product = $this->stmt->fetch(PDO::FETCH_ASSOC);

                $product['additionals'] = $additional->readIngredientsById($product['product_id']);

                $product['banner'] = file_exists(__DIR__ . '/../assets/images/products/' . $product['banner']) 
                    ?
                SERVER_HOST . '/assets/images/products/' . $product['banner']
                    : 
                SERVER_HOST . '/assets/images/system/placeholder.png';

                return $product;

            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readByProductId($id)
    {
        try {

            $this->setSql("SELECT * FROM {$this->table} WHERE product_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            return $this->stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readByCategoryId($id)
    {
        try {

            $this->setSql("SELECT P.*, C.name as category FROM " . $this->table . " as P INNER JOIN product_category as C ON C.category_id = P.category_id WHERE P.category_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                
                $products =  $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach($products as $key => $product) {
                    $products[$key]['banner'] = file_exists(__DIR__ . '/../assets/images/products/' . $products[$key]['banner']) 
                        ?
                    SERVER_HOST . '/assets/images/products/' . $products[$key]['banner']
                        : 
                    SERVER_HOST . '/assets/images/system/placeholder.png';
                }

                return $products;

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

            $this->setSql("SELECT * FROM " . $this->table . " WHERE slug = '{$slug}'");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                
                $product =  $this->stmt->fetch(PDO::FETCH_ASSOC);
                
                $product['banner'] = file_exists(__DIR__ . '/../assets/images/products/' . $product['banner']) 
                    ?
                SERVER_HOST . '/assets/images/products/' . $product['banner']
                    : 
                SERVER_HOST . '/assets/images/system/placeholder.png';

                return $product;

            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function readBySearch($search)
    {
        try {

            $this->setSql("SELECT P.* FROM " . $this->table . " P INNER JOIN product_category as C on P.category_id = C.category_id WHERE P.name LIKE '%$search%' AND P.status = 1 AND C.status = 1");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                
                $products =  $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach($products as $key => $product) {
                    $products[$key]['banner'] = file_exists(__DIR__ . '/../assets/images/products/' . $products[$key]['banner']) 
                        ?
                    SERVER_HOST . '/assets/images/products/' . $products[$key]['banner']
                        : 
                    SERVER_HOST . '/assets/images/system/placeholder.png';
                }

                return $products;

            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function countBySlug($slug, $multiple = false)
    {
        $condition = $multiple ? 'LIKE' : '=';

        try {

            $this->setSql("SELECT * FROM " . $this->table . " WHERE slug $condition '{$slug}%'");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();
            
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateById($id, $data)
    {
        try {

            $specialPrice = isset($data['special_price']) ? $data['special_price'] : 'NULL';

            $this->setSql("UPDATE " . $this->table . " SET category_id = " . $data['category_id'] . ", name = '" . $data['name'] . "', description = '" . $data['description'] . "', special_price = $specialPrice, price = " . $data['price'] .", status = " . $data['status'] . ", slug = '" . $data['slug'] . "' WHERE product_id = $id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            if (!empty($data['banner']['tmp_name'])) {

                $id = $this->conn->query("SELECT product_id FROM " . $this->table . " WHERE slug = '" . $data['slug'] . "'")->fetch(PDO::FETCH_ASSOC);

                $destiny = $this->createFile($_FILES['banner'], $id['product_id']);

                $this->updateByField($destiny, 'banner', $id['product_id']);

            }

        } catch (PDOException $e) {
            return $e->getMessage();
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
            echo $e->getMessage();
        }

    }

    public function deleteFile($banner)
    {
        $destiny = __DIR__ . '/../assets/images/products/' . $banner;

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