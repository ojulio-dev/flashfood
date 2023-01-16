<?php

namespace Model;

use Classes\Database;

use PDO;
use PDOException;

class User extends Database {
    private $stmt, $sql, $table, $conn;

    public function __construct()
    {
        $this->setConn(parent::conn());

        $this->setTable('user');
    }

    private function createFile($file, $extension, $id) {

        $newName = $id . '.' . $extension;

        $destiny = __DIR__ . '/../assets/images/user/' . $newName;

        if (file_exists($destiny)) unlink($destiny);

        move_uploaded_file($file['tmp_name'], $destiny);

        return "$newName";
    }

    public function create($name, $email, $password, $role, $birthdate)
    {
        try {

            $emailExists = $this->conn->query("SELECT email FROM " . $this->table . " WHERE email = '{$email}'")->fetch(PDO::FETCH_ASSOC);

            if ($emailExists) {
                $response = [
                    'response' => false,
                    'message' => 'O E-mail inserido já foi cadastrado! Adicione outro e tente novamente.'
                ];

                echo json_encode($response, JSON_UNESCAPED_UNICODE);

                exit();
            }
            
            $this->setSql("INSERT INTO " . $this->table . " (name, email, password, role_id, birthdate) VALUES ('{$name}', '{$email}', '{$password}', {$role}, '{$birthdate}')");
    
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
            
            $this->setSql("SELECT U.*, R.name as role FROM user as U INNER JOIN role R on U.role_id = R.role_id");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function readByEmail($email)
    {
        try {
            
            $this->setSql("SELECT * FROM {$this->table} WHERE email = BINARY '$email'");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function readById($id)
    {
        try {
            
            $this->setSql("SELECT U.*, R.name as role, R.role_id FROM user as U INNER JOIN role R on U.role_id = R.role_id WHERE user_id = {$id}");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function checkUser($email, $password)
    {
        try {
            
            $this->setSql("SELECT user_id, name, email, role_id, image, birthdate FROM " . $this->getTable() . " WHERE email = '$email' AND BINARY password = '$password' AND status = 1");

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

    public function update($data, $id)
    {
        try {
            
            $this->setSql("UPDATE " . $this->table . " SET name = '" . $data['name'] . "', email = '" . $data['email'] . "', password = '" . $data['password'] . "', role_id = " . $data['role'] . ", birthdate = '" . $data['birthdate'] . "' WHERE user_id = {$id}");

            $this->stmt = $this->conn->prepare($this->getSql());

            if ($this->stmt->execute()) {

                if (!empty($data['image']['tmp_name'])) {
    
                    $destiny = $this->createFile($data['image'], $data['image']['extension'], $id);
    
                    $this->updateByField($destiny, 'image', $id);
    
                }

                return true;
                
            } else {
                return false;
            }

        } catch (PDOException $e) {
            throw $e->getMessage();
        }
    }

    public function updateByField($data, string $field, $userId): bool
    {
        try {
            
            $this->setSql(
            "UPDATE " . $this->table . "
                SET $field = '$data'
            WHERE
                user_id = {$userId}
            ");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function delete($userId)
    {
        try {
            
            $this->setSql("DELETE FROM {$this->table} WHERE user_id = $userId");

            $this->stmt = $this->conn->prepare($this->getSql());

            $this->stmt->execute();

            return $this->stmt->rowCount();
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Getters e Setters
    public function setSql($sql) {
        $this->sql = $sql;
    }

    public function getSql() {
        return $this->sql;
    }

    public function setStmt($stmt)
    {
        $this->stmt = $stmt;
    }

    public function getStmt()
    {
        return $this->stmt;
    }

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }
}