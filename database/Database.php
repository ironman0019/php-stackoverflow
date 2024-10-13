<?php

namespace Database;

use PDO;
use PDOException;

class Database {

    private $conn;

    private $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ];

    private $dbHost = DB_HOST;
    private $dbName = DB_NAME;
    private $dbUsername = DB_USERNAME;
    private $dbPassword = DB_PASSWORD;


    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword, $this->options);

        } catch (PDOException $e) {
            echo 'ERROR - ' . $e->getMessage();
        }
    }


    public function select($sql, $values = null)
    {
        try {
            $stmt = $this->conn->prepare($sql);

            if($values == null) {

                $stmt->execute();

            } else {

                $stmt->execute($values);
            }
            $resault = $stmt;
            return $resault;
        } catch (PDOException $e) {
            echo 'ERROR - ' . $e->getMessage();
            return false;
        }
    }


    public function insert($tableName, array $fields, array $values)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO $tableName (" . implode(', ', $fields) . ", created_at) VALUES (:" . implode(', :', $fields) . ", NOW());");
            $stmt->execute(array_combine($fields, $values));
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo 'ERROR - ' . $e->getMessage();
            return false;
        }
    }


    public function update($tableName, $id, array $fields, array $values)
    {
        $sql = "UPDATE $tableName SET ";
        foreach(array_combine($fields, $values) as $field => $value) {
            if($value) {
                $sql .= $field . " = ? ,";
            } else {
                $sql .= $field . " = Null ,";
            }
        }

        $sql .= "updated_at = NOW()";
        $sql .= "WHERE id = ?;";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array_merge(array_filter(array_values($values)), [$id]));
            return true;
        } catch (PDOException $e) {
            echo 'ERROR - ' . $e->getMessage();
            return false;
        }
    }


    public function delete($tableName, $id)
    {
        $sql = "DELETE FROM $tableName WHERE id = ?;";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            echo 'ERROR - ' . $e->getMessage();
            return false;
        }
    }


    public function createTable($sql): bool
    {
        try {
            $this->conn->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo 'ERROR - ' . $e->getMessage();
            return false;
        }
    }



    
}