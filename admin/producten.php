<?php
include 'main.php';
$pdo_function = pdo_connect_mysql();

$stmt = $pdo_function->prepare('SELECT * FROM producten p inner join categorie c on p.categorie_id = c.categorie_id order by  p.categorie_id, p.product_naam ASC');
$stmt->execute();
$producten = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>


<main class="flex-shrink-0" role="main">
    <div class="container">

<h2>Producten</h2>

<div class="links">
    <a href="product.php">Create</a>
</div>

<div class="content-block">
    <div class="table">

        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Categorie</th>
                <th scope="col">Naam</th>
                <th scope="col">Verpakking</th>
                <th scope="col">Prijs</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($producten)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no accounts</td>
                </tr>
            <?php else: ?>
                <?php foreach ($producten as $product): ?>
                    <tr class="details" onclick="location.href='product.php?product_id=<?= $product['product_id']?>'">
                        <td><?= $product['product_id'] ?></td>
                        <td><?= $product['categorie_naam'] ?></td>
                        <td><?= $product['product_naam'] ?></td>
                        <td><?= $product['verpakking'] ?></td>
                        <td><?= $product['eenheidsprijs'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
