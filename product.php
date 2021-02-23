<?php
$menu = 3;
$error = '';
include 'main.php';

$pdo_function = pdo_connect_mysql();
if (isset($_GET['id'])) {
    $stmt = $pdo_function->prepare("SELECT * FROM producten WHERE product_level = 'actief' and product_id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        $error = 'Product bestaat niet!';
    }
    $stmt = $pdo_function->prepare('SELECT optie_titel, GROUP_CONCAT(optie_naam) AS opties, GROUP_CONCAT(eenheidsprijs) AS optie_eenheidsprijs FROM product_opties WHERE product_id = ? GROUP BY optie_titel');
    $stmt->execute([$_GET['id']]);
    $product_opties = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $error = 'Product bestaat niet!';
}
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga product info</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">

        <?php if ($error): ?>

            <p class="content-wrapper error"><?= $error ?></p>

        <?php else: ?>

            <div class="row" id="content-wrapper">
                <div class="col-md">
                    <div class="card md-12">
                        <div class="row no-gutters g-0">
                            <div class="col-md-4">
                                <?php if (!empty($product['product_foto']) && file_exists('images/producten/' . $product['product_foto'])): ?>
                                    <img src="images/producten/<?= $product['product_foto'] ?>" class="card-img-top"
                                         alt="<?= $product['product_naam'] ?>">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-header text-uppercase"> <?= $product['product_naam'] ?></h5>
                                <div class="card-body">
                                    <p class="card-text"><?= $product['product_info'] ?></p>
                                    <?php if (!empty($product['verpakking'])): ?>
                                        <p class="card-text">Verpakking: <?= $product['verpakking'] ?></p>
                                    <?php endif; ?>
                                    <p class="text-danger"><?= $product['waarschuwing'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <form class="form-inline mt-2 mt-sm-2" id="product-form" action="winkelmand.php"
                                  method="post">
                                <div class="input-group mr-2">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text eenheidsprijs" id="winkelmand">
                                      €&nbsp;<?= number_format($product['eenheidsprijs'], 2) ?>
                                    </span>
                                    </div>

                                    <?php foreach ($product_opties as $optie): ?>
                                        <select class="form-control" aria-label="optie"
                                                name="optie-<?= $optie['optie_titel'] ?>" required>
                                            <option value="" selected disabled
                                                    style="display:none"><?= $optie['optie_titel'] ?></option>
                                            <?php
                                            $optie_naam = explode(',', $optie['opties']);
                                            $optie_eenheidsprijs = explode(',', $optie['optie_eenheidsprijs']);
                                            ?>
                                            <?php foreach ($optie_naam as $k => $naam): ?>
                                                <option value="<?= $naam ?>"
                                                        data-eenheidsprijs="<?= $optie_eenheidsprijs[$k] ?>"><?= $naam ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endforeach; ?>

                                    <input type="number" class="form-control" name="aantal" id="aantal"
                                           aria-describedby="winkelmand" aria-label="Aantal" value="1" min="1"
                                           placeholder="Aantal" required>
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-success" type="submit"><i
                                                    class="fas fa-shopping-basket"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row"><br></div>
    </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
<script>
    if (document.querySelector(".card-footer #product-form .input-group")) {
        document.querySelectorAll(".card-footer #product-form .input-group select").forEach(ele => {
            ele.onchange = () => {
                let eenheidsprijs = 0.00;
                document.querySelectorAll(".card-footer #product-form .input-group select").forEach(e => {
                    if (e.value) {
                        eenheidsprijs += parseFloat(e.options[e.selectedIndex].dataset.eenheidsprijs);
                    }
                });
                if (eenheidsprijs > 0.00) {
                    document.querySelector(".card-footer .eenheidsprijs").innerHTML = '€&nbsp;' + eenheidsprijs.toFixed(2);
                }
            };
        });
    }
</script>
</body>
</html>