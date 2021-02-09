<?php
$menuadmin = 4;
include 'main.php';
$pdo_function = pdo_connect_mysql();

$order_by_list = array('order_id','product_naam','order_datum','order_status');
$order_by = isset($_GET['order_by']) && in_array($_GET['order_by'], $order_by_list) ? $_GET['order_by'] : 'order_id';
$order_sort = isset($_GET['order_sort']) && $_GET['order_sort'] == 'DESC' ? 'DESC' : 'ASC';

// Get orders
$stmt = $pdo_function->prepare('SELECT p.product_foto AS img, p.product_naam, o.*, od.product_prijs, od.product_aantal, od.product_optie FROM orders o JOIN order_details od ON od.order_nr = o.order_nr
    JOIN producten p ON p.product_id = od.product_id ORDER BY ' . $order_by . ' ' . $order_sort);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga admin orders</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga-admin.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">




    </div>
</main>

<?php include('includes/footer.php'); ?>
</body>
</html>

