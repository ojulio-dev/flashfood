<?php

namespace Dashboard\Model;

use Dashboard\Classes\Database;

class Item extends Database{

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'item';
    }

    private function createFile($file, $id) {

        $extension = strtolower( substr($file['name'], -4) );

        $newName = $id . $extension;

        $destiny = __DIR__ . '/../assets/images/item/' . $newName;

        if (file_exists($destiny)) unlink($destiny);

        move_uploaded_file($file['tmp_name'], $destiny);

        return "$newName";
    }

    public function create($data)
    {
        try {

            $this->setSql("INSERT INTO " . $this->table . "(category_id, name, description, special_price, price, slug, status) VALUES (" . $data['category_id'] . ", '" . $data['name'] . "', '" . $data['description'] . "', " . $data['special_price'] .", " . $data['price'] .", '" . $data['slug'] . "', " . $data['status'] . ")");

            $this->stmt = $this->conn()->prepare($this->getSql());

            $this->stmt->execute();
            
            if ($this->stmt->rowCount()) {
                $id = $this->conn->query("SELECT item_id FROM " . $this->table . " WHERE slug = '" . $data['slug'] . "'")->fetch(\PDO::FETCH_ASSOC);

                $destiny = $this->createFile($_FILES['banner'], $id['item_id']);

                $this->updateByField($destiny, 'banner', $id['item_id']);

                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateByField($data, string $field, $itemId): bool
    {
        try {
            $this->setSql(
            "UPDATE " . $this->table . "
                SET $field = '$data'
            WHERE
                item_id = $itemId
            ");

            $this->stmt = $this->conn->query($this->getSql());

            if ($this->stmt->rowCount()) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
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