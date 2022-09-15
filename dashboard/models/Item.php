<?php

namespace Dashboard\Model;

use Dashboard\Classes\Database;
use PDO;

class Item extends Database{

    private $stmt, $sql, $conn, $table;

    public function __construct()
    {
        $this->conn = parent::conn();

        $this->table = 'item';
    }

    public function create($data)
    {
        $this->setSql("INSERT INTO " . $this->table . "(category_id, name, banner, description, special_price, price, slug, status) VALUES (" . $data['category_id'] . ", " . $data['name'] . ", " . $data['banner'] . ", " . $data['description'] . ", " . $data['special_price'] .", " . $data['price'] .", " . $data['slug'] . ", " . $data['status'] . ")");

        $this->stmt = $this->conn()->prepare($this->getSql);

        $this->stmt->execute();

        if ($this->stmt->rowCount()) {
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
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