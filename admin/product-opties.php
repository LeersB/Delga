<?php
$menuadmin = 3;
include 'main.php';
$pdo_function = pdo_connect_mysql();
// Default input product values
$optie = array(
    'optie_id' => '',
    'optie_titel' => '',
    'optie_naam' => '',
    'eenheidsprijs' => '',
    'product_id' => ''
);

if (isset($_GET['product_id'])) {
    // Get product van database
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = ?');
    $stmt->execute([$_GET['product_id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get product_opties van database
    $stmt = $pdo_function->prepare('SELECT * FROM product_opties WHERE product_id = ?');
    $stmt->execute([$_GET['product_id']]);
    $opties = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['optie'])) {
    // Get product_opties van database
    $stmt = $pdo_function->prepare('SELECT * FROM product_opties WHERE optie_id = ?');
    $stmt->execute([$_POST['optie']]);
    $optie = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['optie_id'])) {
    if (isset($_POST['submit'])) {
        // Update product_opties
        $stmt = $pdo_function->prepare('UPDATE product_opties SET optie_titel = ?, optie_naam = ?, eenheidsprijs = ?, product_id = ? WHERE optie_id = ?');
        $stmt->execute([$_POST['optie_titel'], $_POST['optie_naam'], $_POST['eenheidsprijs'], $_POST['product_id'], $_POST['optie_id']]);
        header('Location: product-opties.php?product_id=' . $_POST['product_id']);
        exit;
    }
    if (isset($_POST['delete'])) {
        // Delete product_opties
        $stmt = $pdo_function->prepare('DELETE FROM product_opties WHERE optie_id = ?');
        $stmt->execute([$_POST['optie_id']]);
        header('Location: product-opties.php?product_id=' . $_POST['product_id']);
        exit;
    }
} else {
    // Create product_opties
    if (isset($_POST['submit'])) {
        $stmt = $pdo_function->prepare('INSERT INTO product_opties (optie_titel, optie_naam, eenheidsprijs, product_id) VALUES (?,?,?,?)');
        $stmt->execute([$_POST['optie_titel'], $_POST['optie_naam'], $_POST['eenheidsprijs'], $_POST['product_id']]);
        header('Location: product-opties.php?product_id=' . $_POST['product_id']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga admin opties</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga-admin.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>

<main class="flex-shrink-0" role="main">
    <div class="container">

        <form class="needs-validation" novalidate action="" method="post" autocomplete="off">
            <div class="content-block">
                <div class="row" id="content-wrapper">
                    <div class="col-md">
                        <div class="card md-12">
                            <div class="row no-gutters g-0">
                                <div class="col-md-4">
                                    <?php if (!empty($product['product_foto']) && file_exists('../images/producten/' . $product['product_foto'])): ?>
                                        <img src="../images/producten/<?= $product['product_foto'] ?>"
                                             class="card-img-top"
                                             alt="<?= $product['product_naam'] ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-header text-uppercase"> <?= $product['product_naam'] ?></h5>
                                    <div class="card-body">
                                        <p class="card-text"><?= $product['omschrijving'] ?></p>
                                        <p class="card-text"><?= $product['product_info'] ?></p>
                                        <?php if (!empty($product['verpakking'])): ?>
                                            <p class="card-text">Verpakking: <?= $product['verpakking'] ?></p>
                                        <?php endif; ?>
                                        <p class="text-danger"><?= $product['waarschuwing'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="input-group mr-2">
                                    <div class="input-group col-md-2">
                                        <label class="sr-only" for="eenheidsprijs">Eenheidsprijs</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-euro-sign"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="eenheidsprijs"
                                                   name="eenheidsprijs"
                                                   value="<?= $product['eenheidsprijs'] ?>"
                                                   placeholder="Prijs" disabled required>
                                        </div>
                                    </div>
                                    <div class="input-group col-md-2">
                                        <label class="sr-only" for="btw">btw</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-receipt"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="btw" name="btw"
                                                   value="<?= $product['btw'] ?>"
                                                   placeholder="btw" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn btn-outline-success"
                                           href="product.php?product_id=<?= $product['product_id'] ?>" role="button"><i
                                                    class="fas fa-pump-soap"></i> Product</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($_POST['optie'])) : ?>
                <form class="needs-validation" novalidate action="" method="post" autocomplete="off">
                    <div class="row">
                        <div class="input-group col-md-12"><br></div>
                        <div class="sr-only input-group col-md-2">
                            <label class="sr-only" for="optie_id">Optie_id</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-hashtag"></i></div>
                                </div>
                                <input type="text" class="form-control" id="optie_id" name="optie_id"
                                       value="<?= $optie['optie_id'] ?>" placeholder="Optie_id" required>
                            </div>
                        </div>
                        <div class="input-group col-md-3">
                            <label class="sr-only" for="optie_titel">Titel</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-list-ol"></i></div>
                                </div>
                                <input type="text" class="form-control" id="optie_titel" name="optie_titel"
                                       value="<?= $optie['optie_titel'] ?>" placeholder="Titel" maxlength="20"
                                       required>
                            </div>
                        </div>
                        <div class="input-group col-md-3">
                            <label class="sr-only" for="optie_naam">Naam</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-signature"></i></div>
                                </div>
                                <input type="text" class="form-control" id="optie_naam" name="optie_naam"
                                       value="<?= $optie['optie_naam'] ?>" placeholder="Naam" maxlength="20"
                                       required>
                            </div>
                        </div>
                        <div class=" sr-only input-group col-md-2">
                            <label class="sr-only" for="product_id">product_id</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-info"></i></div>
                                </div>
                                <input type="text" class="form-control" id="product_id" name="product_id"
                                       value="<?= $optie['product_id'] ?>" placeholder="Product_id" maxlength="4"
                                       required>
                            </div>
                        </div>
                        <div class="input-group col-md-2">
                            <label class="sr-only" for="eenheidsprijs">Eenheidsprijs</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-euro-sign"></i></div>
                                </div>
                                <input type="text" class="form-control" id="eenheidsprijs" name="eenheidsprijs"
                                       value="<?= $optie['eenheidsprijs'] ?>"
                                       placeholder="Prijs" required>
                            </div>
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary"
                               href="product-opties.php?product_id=<?= $optie['product_id'] ?>" role="button"><i
                                        class="fas fa-times"></i></a>
                            <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-check"></i>
                            </button>
                            <button type="submit" name="delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>

            <?php if (isset($_POST['optie_nieuw'])) : ?>
                <form class="needs-validation" novalidate action="" method="post" autocomplete="off">
                    <div class="row">
                        <div class="input-group col-md-12"><br></div>
                        <div class="input-group col-md-3">
                            <label class="sr-only" for="optie_titel">Titel</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-list-ol"></i></div>
                                </div>
                                <input type="text" class="form-control" id="optie_titel" name="optie_titel"
                                       placeholder="Titel" maxlength="20"
                                       required>
                            </div>
                        </div>
                        <div class="input-group col-md-3">
                            <label class="sr-only" for="optie_naam">Naam</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-signature"></i></div>
                                </div>
                                <input type="text" class="form-control" id="optie_naam" name="optie_naam"
                                       placeholder="Naam" maxlength="20"
                                       required>
                            </div>
                        </div>
                        <div class="sr-only input-group col-md-2">
                            <label class="sr-only" for="product_id">product_id</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-info"></i></div>
                                </div>
                                <input type="text" class="form-control" id="product_id" name="product_id"
                                       value="<?= $product['product_id'] ?>" placeholder="Product_id" maxlength="4"
                                       required>
                            </div>
                        </div>
                        <div class="input-group col-md-2">
                            <label class="sr-only" for="eenheidsprijs">Eenheidsprijs</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-euro-sign"></i></div>
                                </div>
                                <input type="text" class="form-control" id="eenheidsprijs" name="eenheidsprijs"
                                       placeholder="Prijs" required>
                            </div>
                        </div>
                        <div class="col-2">
                            <a class="btn btn-secondary"
                               href="product-opties.php?product_id=<?= $product['product_id'] ?>" role="button"><i
                                        class="fas fa-times"></i></a>
                            <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>

            <div class="input-group col-md-12"><br></div>

            <div class="content table-responsive-lg">
                <table class="table table-success table-borderless">
                    <form class="needs-validation" novalidate action="" method="post" autocomplete="off">
                        <thead class="table-light">
                        <tr>
                            <th><i class="fas fa-hashtag"></i></th>
                            <th>Titel</th>
                            <th>Naam</th>
                            <th>Prijs</th>
                            <th>
                                <button type="submit" name="optie_nieuw"
                                        class="btn btn-outline-success"><i class="fas fa-cart-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($opties)): ?>
                            <tr>
                                <td colspan="8" style="text-align:center;">Er zijn geen product opties aanwezig</td>
                            </tr>
                        <?php else: ?>

                            <?php foreach ($opties as $optie): ?>
                                <tr class="details">
                                    <td><?= $optie['optie_id'] ?></td>
                                    <td><?= $optie['optie_titel'] ?></td>
                                    <td><?= $optie['optie_naam'] ?></td>
                                    <td><?= $optie['eenheidsprijs'] ?></td>
                                    <td>
                                        <button type="submit" name="optie"
                                                class="btn btn-outline-success" value="<?= $optie['optie_id'] ?>"><i
                                                    class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php endif; ?>
                        </tbody>
                    </form>
                </table>
            </div>

            <div class="row">
                <div class="input-group col-md-12"><br></div>
                <div class="col-12">
                    <a class="btn btn-secondary" href="producten.php" role="button"><i class="fas fa-times"></i>
                        Annuleer</a>
                </div>
                <div class="input-group col-md-12"><br></div>
            </div>
        </form>

    </div>
</main>

<?php include('includes/footer.php'); ?>
<script src="../js/form-validation.js"></script>
</body>
</html>
