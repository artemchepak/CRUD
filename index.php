<?php

require_once 'vendor/autoload.php';

use App\Crud;

$crud = new Crud();

$products = $crud->read();

if($crud->operation === 'delete'){
    $crud->delete();
} elseif ($crud->operation === 'create') {
    $crud->create();
} elseif ($crud->operation === 'edit') {
    $crud->getEditValues();
} elseif ($crud->operation === 'update') {
    $crud->update();
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

    <h1>Shopping List</h1>
    <br>

    <form action="" method="post">
        <div class="row g-3">
            <div class="col-sm">
                <input type="text" class="form-control" name="name" value="<?php echo $crud->name?>">
            </div>
            <div class="col-sm">
                <input type="text" class="form-control" name="description" value="<?php echo $crud->description?>">
            </div>
            <div class="col-sm-1">
                <input type="text" class="form-control" name="amount" value="<?php echo $crud->amount?>">
            </div>
            <div class="col-sm">
                <?php if ($crud->operation != 'edit'): ?>
                <input type="hidden" name="operation" value="create">
                <button type="submit" class="btn btn-success">Add new product</button>
                <?php endif; ?>

                <?php if ($crud->operation === 'edit'): ?>
                    <input type="hidden" name="operation" value="update">
                    <input type="hidden" name="id" value="<?php echo $crud->id?>">
                    <button type="submit" class="btn btn-primary">Edit product</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <?php if ($crud->operation === 'edit'): ?>
        <a href="index.php">undo editing</a>
    <?php endif; ?>

    <br>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Product</th>
            <th scope="col">Description</th>
            <th scope="col">Amount</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $i => $product): ?>
            <tr>
                <th scope="row"><?php echo $i + 1 ?></th>
                <td><?php echo $product['name'] ?></td>
                <td><?php echo $product['description'] ?></td>
                <td><?php echo $product['amount'] ?></td>
                <td class="table-buttons">
                    <form action="" method="post" style="display: inline-block">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="operation" value="edit">
                        <button type="submit" class="btn btn-outline-primary">Edit</button>
                    </form>
                    <form action="" method="post" style="display: inline-block">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="operation" value="delete">
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>