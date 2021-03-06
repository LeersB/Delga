<?php
$menuadmin = 1;
include '../admin/main.php';
$pdo_function = pdo_connect_mysql();
// Get totaal aantal orders op vandaag
$stmt_orders = $pdo_function->prepare("SELECT p.product_foto AS img, p.product_naam, o.*, od.product_prijs, od.product_aantal, od.product_optie FROM orders o JOIN order_details od ON od.order_nr = o.order_nr
    JOIN producten p ON p.product_id = od.product_id WHERE o.order_status = 'nieuw' AND cast(o.order_datum as DATE) = cast(now() as DATE) ORDER BY o.order_datum DESC");
$stmt_orders->execute();
$orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);
// Get orders status nieuw
$stmt_order_status_nieuw = $pdo_function->prepare("SELECT COUNT(*) AS totaal FROM orders WHERE order_status = 'nieuw'");
$stmt_order_status_nieuw->execute();
$order_status_nieuw = $stmt_order_status_nieuw->fetch(PDO::FETCH_ASSOC);
// Get orders status uitvoering
$stmt_order_status_uitvoering = $pdo_function->prepare("SELECT COUNT(*) AS totaal FROM orders WHERE order_status = 'uitvoering'");
$stmt_order_status_uitvoering->execute();
$order_status_uitvoering = $stmt_order_status_uitvoering->fetch(PDO::FETCH_ASSOC);
// Get totaal aantal users
$stmt_users = $pdo_function->prepare("SELECT COUNT(*) AS totaal FROM users");
$stmt_users->execute();
$users = $stmt_users->fetch(PDO::FETCH_ASSOC);
// Get totaal aantal producten
$stmt_producten_actief = $pdo_function->prepare("SELECT COUNT(*) AS totaal FROM producten WHERE product_level = 'actief'");
$stmt_producten_actief->execute();
$producten_actief = $stmt_producten_actief->fetch(PDO::FETCH_ASSOC);
$stmt_producten = $pdo_function->prepare("SELECT COUNT(*) AS totaal FROM producten");
$stmt_producten->execute();
$producten = $stmt_producten->fetch(PDO::FETCH_ASSOC);
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
    <?php include('../admin/includes/header.php'); ?>
</header>

<main class="flex-shrink-0">
    <div class="container">

        <h2>Dashboard voor vandaag</h2>

        <div class="dashboard">
            <div class="content-block stat" onclick="location.href='orders.php'">
                <div>
                    <h3>Nieuw</h3>
                    <p><?=number_format($order_status_nieuw['totaal'])?></p>
                </div>
                <i class="fas fa-mail-bulk"></i>
            </div>
            <div class="content-block stat" onclick="location.href='orders.php?weergaven=uitvoering'">
                <div>
                    <h3>In uitvoering</h3>
                    <p><?=number_format($order_status_uitvoering['totaal'])?></p>
                </div>
                <i class="fas fa-mail-bulk"></i>
            </div>
            <div class="content-block stat" onclick="location.href='producten.php'">
                <div>
                    <h3>Actieve producten</h3>
                    <p><?=number_format($producten_actief['totaal'])?> / <?=number_format($producten['totaal'])?></p>
                </div>
                <i class="fas fa-pump-soap"></i>
            </div>
            <div class="content-block stat">
                <div>
                    <h3>Delga accounts</h3>
                    <p><?=number_format($users['totaal'])?></p>
                </div>
                <i class="fas fa-users"></i>
            </div>
        </div>

            <div class="content table-responsive-lg">
                <table class="table table-hover table-success table-borderless">
                    <thead class="table-light">
                    <tr>
                        <th colspan="2">Product</th>
                        <th class="responsive-hidden">Datum</th>
                        <th class="responsive-hidden">Prijs</th>
                        <th>Aantal</th>
                        <th>Totaal</th>
                        <th class="responsive-hidden">Email</th>
                        <th class="responsive-hidden">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="8" style="text-align:center;">Er zijn geen recente orders vandaag</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr class="details">
                                <td>
                                    <?php if (!empty($order['img']) && file_exists('../images/producten/' . $order['img'])): ?>
                                        <img src="../images/producten/<?=$order['img']?>" width="32" height="32" alt="<?=$order['product_naam']?>">
                                    <?php endif; ?>
                                </td>
                                <td><?=$order['product_naam']?> <?=$order['product_optie']?></td>
                                <td class="responsive-hidden"><?=date('d-m-Y', strtotime($order['order_datum']))?></td>
                                <td class="responsive-hidden">€ <?=number_format($order['product_prijs'],2)?></td>
                                <td><?=$order['product_aantal']?></td>
                                <td>€&nbsp;<?=number_format($order['product_prijs'] * $order['product_aantal'], 2)?></td>
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
                                            <span><?=$order['order_naam']?></span>
                                        </div>
                                        <div>
                                            <span>Email</span>
                                            <span><?=$order['order_email']?></span>
                                        </div>
                                        <div>
                                            <span>Facturatieadres</span>
                                            <span><?=$order['order_adres']?></span>
                                        </div>
                                        <div>
                                            <span>Leveringsadres</span>
                                            <span><?=$order['order_adres_2']?></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

    </div>
</main>

<?php include('../admin/includes/footer.php'); ?>
<script>
    document.querySelectorAll(".details").forEach(function(detail) {
        detail.onclick = function() {
            let display = this.nextElementSibling.style.display === 'table-row' ? 'none' : 'table-row';
            this.nextElementSibling.style.display = display;
        };
    });
</script>
</body>
</html>