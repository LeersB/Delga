<?php
$menuadmin = 3;
include '../admin/main.php';
$pdo_function = pdo_connect_mysql();

$filter_order_by = filter_input(INPUT_GET, 'order_by', FILTER_SANITIZE_STRING);
$filter_order_sort = filter_input(INPUT_GET, 'order_sort', FILTER_SANITIZE_STRING);

$order_by_list = array('categorie_id', 'categorie_naam');
$order_by = isset($filter_order_by) && in_array($filter_order_by, $order_by_list) ? $filter_order_by : 'categorie_id';
$order_sort = isset($filter_order_sort) && $filter_order_sort == 'DESC' ? 'DESC' : 'ASC';

$stmt = $pdo_function->prepare('SELECT * FROM  categorie ORDER BY ' . $order_by . ' ' . $order_sort);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga admin categorieën</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga-admin.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('../admin/includes/header.php'); ?>
</header>

<main class="flex-shrink-0">
    <div class="container">

        <h2>Categorieën</h2>

        <div class="content table-responsive-lg">
            <table class="table table-hover table-success table-borderless">
                <thead class="table-light">
                <tr>
                    <th>
                        <a href="categories.php?order_by=categorie_id&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            <i class="fas fa-hashtag"></i>
                            <?php if ($order_by == 'categorie_id'): ?>
                                <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="categories.php?order_by=categorie_naam&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                            Categorie naam
                            <?php if ($order_by == 'categorie_naam'): ?>
                                <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">Er zijn geen categorieën aanwezig</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $categorie): ?>
                        <tr class="details">
                            <!--<tr class="details" onclick="location.href='categorie.php?categorie_id=<?= $categorie['categorie_id'] ?>'">-->
                            <td><?= $categorie['categorie_id'] ?></td>
                            <td><?= $categorie['categorie_naam'] ?></td>
                            <!--<td><a class="btn btn-outline-danger" href="categorie-delete.php?categorie_id=<?= $categorie['categorie_id'] ?>" role="button"><i class="fas fa-trash-alt"></i></a></td>-->
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<?php include('../admin/includes/footer.php'); ?>

</body>
</html>