<?php

namespace App;

use App\Db;
use PDO;

class ShoppingList
{
    private $db;
    public $operation;
    public $id;
    public $name;
    public $description;
    public $amount;

    public function __construct()
    {
        $this->db = new Db();
        $this->db->connectDb();
        $this->db->table = 'products';

        $this->operation = $_POST['operation'] ?? null;
        $this->id = $_POST['id'] ?? null;
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//          array_pop удаляет operation

            $keys = array_keys($_POST);
            array_pop($keys);

            $values = [];
            $bindParams = [];

            foreach ($_POST as $key => $value){
                array_push($values, ":$key");
                $bindParams += [':' . $key => $value];
            }
            array_pop($values);
            array_pop($bindParams);

            $createKeys = implode(',', $keys);
            $createValues = implode(',', $values);

            $query = $this->db->create($createKeys, $createValues);
            $this->db->executeQuery($query, $bindParams);
            $this->operation = '';
            header('Location: index.php');
        }
    }

    public function read()
    {
        $query = $this->db->select('*');
        $result = $this->db->executeQuery($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $updateParamArr = [];
            $bindParams = [];
            foreach ($_POST as $key => $value){
                if ($key != 'id' && $key != 'operation'){
                    array_push($updateParamArr, "$key = :$key");
                    $bindParams += [':' . $key => $value];
                    }
            }
            $updateParam = implode(',', $updateParamArr);

            $query = $this->db->update($updateParam, $this->id);
            $this->db->executeQuery($query, $bindParams);
            $this->operation = '';
            header('Location: index.php');
        }
    }

    public function delete()
    {
        $query = $this->db->delete($this->id);
        $this->db->executeQuery($query);
        $this->operation = '';
        header('Location: index.php');
    }

    public function getEditValues()
    {
        $query = $this->db->select('*', $this->id);
        $result = $this->db->executeQuery($query);
        $editItem = $result->fetchAll(PDO::FETCH_ASSOC)[0];
        return $editItem;
    }
}