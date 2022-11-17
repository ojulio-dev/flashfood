<?php

namespace Classes;

use PDO;
use PDOException;

require_once(__DIR__ . '/../config/config.php');

class Database {

    public static function conn()
    {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

        return $conn;
    }

    public function lastInsertId($table)
    {
        try {

            $id = $table . '_id';
            
            $sql = "SELECT MAX({$id}) as id FROM $table";

            $stmt = $this->conn()->prepare($sql);

            $stmt->execute();

            $id = $stmt->fetch()['id'];

            return $id;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
