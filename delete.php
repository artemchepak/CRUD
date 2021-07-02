<?php

$id = $_POST['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

try {
    $pdo= new PDO('mysql:host=mysql;port=3306;dbname=shopping_list', 'admin', 'admin');
} catch (PDOException $e) {
    die($e->getMessage());
}

$statement = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();

header('Location: index.php');