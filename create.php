<?php
try {
    $pdo= new PDO('mysql:host=mysql;port=3306;dbname=shopping_list', 'admin', 'admin');
} catch (PDOException $e) {
    die($e->getMessage());
}

$errors = [];
$name = '';
$description = '';
$amount = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    if (!$name){
        array_push($errors, 'Name is not provided');
    }
    if (!$amount){
        array_push($errors, 'Amount is not provided');
    }

    if (empty($errors)){
        $statement = $pdo->prepare("INSERT INTO products (name, description, amount) VALUE (:name, :description, :amount)");
        $statement->bindValue(':name', $name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':amount', $amount);
        $statement->execute();
        header('Location: index.php');
    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

<div class="container">

    <a href="index.php">Back to shopping list</a>

    <h1>Add new product</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div>
                    <?php echo $error?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo $name?>">
        </div>
        <div class="mb-3">
            <label>Descripton</label>
            <input type="text" class="form-control" name="description" value="<?php echo $description?>">
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="text" class="form-control" name="amount" value="<?php echo $amount?>">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

</div>

</body>
</html>