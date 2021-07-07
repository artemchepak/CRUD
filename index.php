<?php

require_once 'vendor/autoload.php';

use App\ShoppingList;

$shoppingList = new ShoppingList();

$products = $shoppingList->read();
$editItem = $shoppingList->getEditValues();

if ($shoppingList->operation === 'delete') {
    $shoppingList->delete();
} elseif ($shoppingList->operation === 'create') {
    $shoppingList->create();
}  elseif ($shoppingList->operation === 'update') {
    $shoppingList->update();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

<div class="container">

    <h1>Shopping List</h1>
    <br>

    <form action="" method="post">
        <div class="row g-3">

            <?php foreach ($editItem as $key => $value): ?>
                <?php if ($key !== 'id'): ?>

                    <div class="col-sm">
                        <input type="text" class="form-control" name="<?php echo $key ?>" value="<?php echo $shoppingList->operation === 'edit' ? $value : '' ?>">
                    </div>

                <?php endif; ?>
            <?php endforeach; ?>

            <div class="col-sm">
                <?php if ($shoppingList->operation != 'edit'): ?>
                    <input type="hidden" name="operation" value="create">
                    <button type="submit" class="btn btn-success">Add new product</button>
                <?php endif; ?>

                <?php if ($shoppingList->operation === 'edit'): ?>
                    <input type="hidden" name="operation" value="update">
                    <input type="hidden" name="id" value="<?php echo $shoppingList->id ?>">
                    <button type="submit" class="btn btn-primary">Edit product</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <?php if ($shoppingList->operation === 'edit'): ?>
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
                <?php foreach ($product as $key => $value): ?>
                    <?php if ($key !== 'id'): ?>
                        <td><?php echo $value ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>

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