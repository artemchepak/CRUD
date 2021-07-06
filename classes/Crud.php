<?php

namespace App;

use PDO;

class Crud
{
    private $pdo;
    public $operation;
    public $id;
    public $name;
    public $description;
    public $amount;

    public function __construct(){
        try {
            $this->pdo = new PDO('mysql:host=mysql;port=3306;dbname=shopping_list', 'admin', 'admin');
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $this->operation = $_POST['operation'] ?? null;
        $this->id = $_POST['id'] ?? null;
    }

    public function create(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $this->getFormValues();

            $statement = $this->pdo->prepare("INSERT INTO products (name, description, amount) VALUE (:name, :description, :amount)");
            $statement->bindValue(':name', $this->name);
            $statement->bindValue(':description', $this->description);
            $statement->bindValue(':amount', $this->amount);
            $statement->execute();
            $this->operation = '';
            header('Location: index.php');
        }
    }

    public function read(){
        $request = $this->pdo->prepare('SELECT * FROM products');
        $request->execute();
        $products = $request->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function update(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $this->getFormValues();

            $statement = $this->pdo->prepare("UPDATE products SET name = :name, description = :description, amount = :amount WHERE id = :id");
            $statement->bindValue(':name', $this->name);
            $statement->bindValue(':description', $this->description);
            $statement->bindValue(':amount', $this->amount);
            $statement->bindValue(':id', $this->id);
            $statement->execute();
            $this->operation = '';
            header('Location: index.php');
        }
    }

    public function delete(){
        $statement = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
        $statement->bindValue(':id', $this->id);
        $statement->execute();
        $this->operation = '';
        header('Location: index.php');
    }

    public function getEditValues(){
        $statement = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $statement->bindValue(':id', $this->id);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        $this->name = $product['name'];
        $this->description = $product['description'];
        $this->amount = $product['amount'];
    }

    private function getFormValues(){
        $this->name = $_POST['name'];
        $this->description = $_POST['description'];
        $this->amount = $_POST['amount'];
    }
}