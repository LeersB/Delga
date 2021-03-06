<?php
$menuadmin = 3;
include '../admin/main.php';
$pdo_function = pdo_connect_mysql();

$filter_product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);

// Default input product values
$product = array(
    'product_id' => '',
    'categorie_id' => '',
    'product_naam' => '',
    'product_foto' => '',
    'product_info' => '',
    'omschrijving' => '',
    'verpakking' => '',
    'waarschuwing' => '',
    'eenheidsprijs' => '',
    'btw' => '21',
    'product_level' => 'niet-actief'
);
$product_opties = array(
    'optie_id' => '',
    'product_id' => ''
);
$product_levels = array('actief', 'niet-actief');
// Get categories van database
$stmt_categories = $pdo_function->prepare('SELECT * FROM categorie');
$stmt_categories->execute();
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

if (isset($filter_product_id)) {
    // Get product van database
    $stmt_product = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = ?');
    $stmt_product->execute([$filter_product_id]);
    $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

    // Get product_opties van database
    $stmt_product_opties = $pdo_function->prepare('SELECT optie_id FROM product_opties WHERE product_id = ?');
    $stmt_product_opties->execute([$filter_product_id]);
    $product_opties = $stmt_product_opties->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['submit'])) {
        // Update product
        $stmt = $pdo_function->prepare('UPDATE producten SET categorie_id = ?, product_naam = ?, product_foto = ?, product_info = ?, omschrijving = ?, verpakking = ?, waarschuwing = ?, eenheidsprijs = ?, btw = ? , product_level = ? WHERE product_id = ? LIMIT 1');
        $stmt->execute([$_POST['categorie_id'], $_POST['product_naam'], $_POST['product_foto'], $_POST['product_info'], $_POST['omschrijving'], $_POST['verpakking'], $_POST['waarschuwing'], $_POST['eenheidsprijs'], $_POST['btw'], $_POST['product_level'], $filter_product_id]);
        header('Location: producten.php');
        exit;
    }
    if (isset($_POST['update'])) {
        // Update product in scherm
        $stmt = $pdo_function->prepare('UPDATE producten SET categorie_id = ?, product_naam = ?, product_foto = ?, product_info = ?, omschrijving = ?, verpakking = ?, waarschuwing = ?, eenheidsprijs = ?, btw = ? , product_level = ? WHERE product_id = ? LIMIT 1');
        $stmt->execute([$_POST['categorie_id'], $_POST['product_naam'], $_POST['product_foto'], $_POST['product_info'], $_POST['omschrijving'], $_POST['verpakking'], $_POST['waarschuwing'], $_POST['eenheidsprijs'], $_POST['btw'], $_POST['product_level'], $filter_product_id]);
        header('Location: product.php?product_id=' . $filter_product_id);
        exit;
    }
    if (isset($_POST['delete'])) {
        // Delete product
        $stmt = $pdo_function->prepare('DELETE FROM producten WHERE product_id = ? LIMIT 1');
        $stmt->execute([$filter_product_id]);
        header('Location: producten.php');
        exit;
    }
} else {
    // Create product
    if (isset($_POST['submit'])) {
        $stmt = $pdo_function->prepare('INSERT IGNORE INTO producten (categorie_id, product_naam, product_foto, product_info, omschrijving, verpakking, waarschuwing, eenheidsprijs, btw, product_level) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$_POST['categorie_id'], $_POST['product_naam'], $_POST['product_foto'], $_POST['product_info'], $_POST['omschrijving'], $_POST['verpakking'], $_POST['waarschuwing'], $_POST['eenheidsprijs'], $_POST['btw'], $_POST['product_level']]);
        header('Location: producten.php');
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
    <title>Delga admin product</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga-admin.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('../admin/includes/header.php'); ?>
</header>

<main class="flex-shrink-0">
    <div class="container">

        <form class="needs-validation" novalidate action="" method="post" autocomplete="off">

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
                                <div class="input-group col-md-3">
                                    <label class="sr-only" for="eenheidsprijs">Eenheidsprijs</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-euro-sign"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="eenheidsprijs"
                                               name="eenheidsprijs"
                                               value="<?= $product['eenheidsprijs'] ?>"
                                               placeholder="Prijs" required>
                                    </div>
                                </div>
                                <div class="input-group col-md-3">
                                    <label class="sr-only" for="btw">btw</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-receipt"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="btw" name="btw"
                                               value="<?= $product['btw'] ?>"
                                               placeholder="btw" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-2">
                                        <label class="sr-only" for="product_level">Level</label>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-list-ol"></i></div>
                                        </div>
                                        <select class="custom-select" id="product_level" name="product_level">
                                            <?php foreach ($product_levels as $level): ?>
                                                <option value="<?= $level ?>"<?= $level == $product['product_level'] ? ' selected' : '' ?>><?= $level ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <?php if (isset($filter_product_id)): ?>
                                        <?php if ($product_opties != null) { ?>
                                            <a class="btn btn-outline-success"
                                               href="product-opties.php?product_id=<?= $product['product_id'] ?>"
                                               role="button"><i class="fas fa-cart-plus"></i> Opties</a>
                                        <?php } else { ?>
                                            <a class="btn btn-outline-secondary"
                                               href="product-opties.php?product_id=<?= $product['product_id'] ?>"
                                               role="button"><i class="fas fa-cart-plus"></i> Opties</a>
                                        <?php } endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="input-group col-md-12"><br></div>
                <div class="input-group col-md-6">
                    <label class="sr-only" for="product_naam">Naam</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-store"></i></div>
                        </div>
                        <input type="text" class="form-control" id="product_naam" name="product_naam"
                               value="<?= $product['product_naam'] ?>" placeholder="Product naam" maxlength="60"
                               required>
                    </div>
                </div>
                <div class="input-group col-md-6">
                    <label class="sr-only" for="product_foto">Foto</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="far fa-image"></i></div>
                        </div>
                        <input type="text" class="form-control" id="product_foto" name="product_foto"
                               value="<?= $product['product_foto'] ?>" placeholder="Product foto" maxlength="60"
                               required>
                    </div>
                </div>
                <div class="input-group col-md-6">
                    <div class="input-group mb-2">
                        <label class="sr-only" for="categorie_id">Categorie</label>
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-list-ol"></i></div>
                        </div>
                        <select class="custom-select" id="categorie_id" name="categorie_id">
                            <?php foreach ($categories as $categorie): ?>
                                <option value="<?= $categorie['categorie_id'] ?>"<?= $categorie['categorie_id'] == $product['categorie_id'] ? ' selected' : '' ?>><?= $categorie["categorie_naam"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="input-group col-md-6">
                    <label class="sr-only" for="product_foto">Verpakking</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-box-open"></i></div>
                        </div>
                        <input type="text" class="form-control" id="verpakking" name="verpakking"
                               value="<?= $product['verpakking'] ?>"
                               placeholder="Verpakking" maxlength="60">
                    </div>
                </div>
                <div class="input-group col-md-6">
                    <label class="sr-only" for="omschrijving">Omschrijving</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-pencil-ruler"></i></div>
                        </div>
                        <textarea class="form-control" id="omschrijving" name="omschrijving"
                                  rows="3" maxlength="300"><?= $product['omschrijving'] ?></textarea>
                    </div>
                </div>
                <div class="input-group col-md-6">
                    <label class="sr-only" for="waarschuwing">Waarschuwing</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-exclamation"></i></div>
                        </div>
                        <textarea class="form-control" id="waarschuwing" name="waarschuwing"
                                  rows="3" maxlength="400"><?= $product['waarschuwing'] ?></textarea>
                    </div>
                </div>
                <div class="input-group col-md-12">
                    <label class="sr-only" for="product_info">product_info</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-info"></i></div>
                        </div>
                        <textarea class="form-control" id="product_info" name="product_info"
                                  rows="6" maxlength="600"><?= $product['product_info'] ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row justify-content-md-start py-3">
                <div class="col-lg-auto col-3">
                    <a class="btn btn-sm-0 btn-secondary" href="producten.php" role="button"><i
                                class="fas fa-times"></i>
                        Annuleer</a>
                </div>
                <?php if (isset($filter_product_id)): ?>
                    <div class="col-lg-auto col-3">
                        <button type="submit" name="update" class="btn btn-success"><i class="fas fa-check"></i> Updaten
                        </button>
                    </div>
                <?php endif ?>
                <div class="col-lg-auto col-3">
                    <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-check-double"></i>
                        Opslaan
                    </button>
                </div>
                <div class="col-lg-auto col-3">
                    <button type="submit" name="delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i>
                        Verwijder
                    </button>
                </div>
            </div>
        </form>

    </div>
</main>

<?php include('../admin/includes/footer.php'); ?>
<script src="../js/form-validation.js"></script>

</body>
</html>