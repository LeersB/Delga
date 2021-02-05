<?php
$menuadmin = 1;
include 'main.php';
$pdo_function = pdo_connect_mysql();

// SQL query that will get all orders and sort by the date created
$stmt = $pdo_function->prepare('SELECT p.product_foto AS img, p.product_naam AS naam, t.*, ti.product_prijs AS price, ti.product_aantal AS quantity, ti.product_optie AS options FROM orders t JOIN order_details ti ON ti.order_nr = t.order_nr
    JOIN producten p ON p.product_id = ti.product_id WHERE cast(t.order_datum as DATE) = cast(now() as DATE) ORDER BY t.order_datum DESC');
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the orders statistics
$stmt = $pdo_function->prepare('SELECT SUM(ti.product_prijs * ti.product_aantal) AS earnings FROM orders t JOIN order_details ti ON ti.order_nr = t.order_nr WHERE cast(t.order_datum as DATE) = cast(now() as DATE) ORDER BY t.order_datum DESC');
$stmt->execute();
$order_stats = $stmt->fetch(PDO::FETCH_ASSOC);
// Get the total number of accounts
$stmt = $pdo_function->prepare('SELECT COUNT(*) AS total FROM users');
$stmt->execute();
$accounts = $stmt->fetch(PDO::FETCH_ASSOC);
// Get the total number of products
$stmt = $pdo_function->prepare('SELECT COUNT(*) AS total FROM producten');
$stmt->execute();
$products = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga admin</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga-admin.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">

        <h2>Dashboard</h2>

        <div class="dashboard">
            <div class="content-block stat">
                <div>
                    <h3>Orders vandaag</h3>
                    <p><?=number_format(count($orders))?></p>
                </div>
                <i class="fas fa-shopping-cart"></i>
            </div>

            <div class="content-block stat">
                <div>
                    <h3>Verdiensten</h3>
                    <p>€ <?=number_format($order_stats['earnings'], 2)?></p>
                </div>
                <i class="fas fa-coins"></i>
            </div>

            <div class="content-block stat">
                <div>
                    <h3>Aantal accounts</h3>
                    <p><?=number_format($accounts['total'])?></p>
                </div>
                <i class="fas fa-users"></i>
            </div>

            <div class="content-block stat">
                <div>
                    <h3>Aantal Producten</h3>
                    <p><?=number_format($products['total'])?></p>
                </div>
                <i class="fas fa-boxes"></i>
            </div>
        </div>

        <h2>Nieuwe orders voor vandaag</h2>

        <div class="content-block">
            <div class="table">
                <table>
                    <thead>
                    <tr>
                        <td colspan="2">Product</td>
                        <td class="responsive-hidden">Date</td>
                        <td class="responsive-hidden">Price</td>
                        <td>Quantity</td>
                        <td>Total</td>
                        <td class="responsive-hidden">Email</td>
                        <td class="responsive-hidden">Status</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="8" style="text-align:center;">There are no recent orders</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr class="details">
                                <td class="img">
                                    <?php if (!empty($order['img']) && file_exists('../images/producten/' . $order['img'])): ?>
                                        <img src="../images/producten/<?=$order['img']?>" width="32" height="32" alt="<?=$order['naam']?>">
                                    <?php endif; ?>
                                </td>
                                <td><?=$order['naam']?></td>
                                <td class="responsive-hidden"><?=date('d-m-Y', strtotime($order['order_datum']))?></td>
                                <td class="responsive-hidden">€ <?=number_format($order['price'],2)?></td>
                                <td><?=$order['quantity']?></td>
                                <td>€ <?=number_format($order['price'] * $order['quantity'], 2)?></td>
                                <td class="responsive-hidden"><?=$order['order_email']?></td>
                                <td class="responsive-hidden"><?=$order['order_status']?></td>
                            </tr>
                            <tr class="expanded-details">
                                <td colspan="8">
                                    <div>
                                        <div>
                                            <span>Order nummer</span>
                                            <span><?=$order['order_nr']?></span>
                                        </div>
                                        <div>
                                            <span>Aangemaakt</span>
                                            <span><?=date('d-m-Y H:i:s', strtotime($order['order_datum']))?></span>
                                        </div>
                                        <div>
                                            <span>Naam</span>
                                            <span><?=$order['order_voornaam']?> <?=$order['order_achternaam']?></span>
                                        </div>
                                        <div>
                                            <span>Email</span>
                                            <span><?=$order['order_email']?></span>
                                        </div>
                                        <div>
                                            <span>Address</span>
                                            <span>
                                    <?=$order['order_adres']?><br>
                                    <?=$order['order_adres_2']?><br>
                                            </span>
                                        </div>
                                        <div>
                                            <span>Opties</span>
                                            <span><?=$order['options']?></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
                <script>
                    document.querySelectorAll(".details").forEach(function(detail) {
                        detail.onclick = function() {
                            let display = this.nextElementSibling.style.display === 'table-row' ? 'none' : 'table-row';
                            this.nextElementSibling.style.display = display;
                        };
                    });
                </script>
            </div>
        </div>


    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
