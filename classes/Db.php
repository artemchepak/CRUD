<?php


namespace App;

use PDO;

class Db
{
    public PDO $pdo;
    public $table;

    public function connectDb()
    {
        try {
            $this->pdo = new PDO('mysql:host=mysql;port=3306;dbname=shopping_list', 'admin', 'admin');
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function select($selectParam, $id = null)
    {
        if (isset($id)){
            $query = "SELECT $selectParam FROM $this->table WHERE id = $id";
        } else{
            $query = "SELECT $selectParam FROM $this->table";
        }
        return $query;
    }

    public function delete($id){
        $query = "DELETE FROM $this->table WHERE id = $id";
        return $query;
    }

    public function update($updateParam, $id){
        $query = "UPDATE $this->table SET $updateParam WHERE id = $id";
        return $query;
    }

    public function create($createKeys, $createValues){
        $query = "INSERT INTO $this->table ($createKeys) VALUE ($createValues)";
        return $query;
    }

    public function executeQuery($query, $bindParams = null)
    {
        $statement = $this->pdo->prepare($query);
        if (!is_null($bindParams)){
            foreach ($bindParams as $key => $value){
                $statement->bindValue($key, $value);
            }
        }
        $statement->execute();
        return $statement;
    }
}