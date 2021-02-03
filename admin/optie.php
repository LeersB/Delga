<?php
$menuadmin = 3;
include 'main.php';
$pdo_function = pdo_connect_mysql();
// Default input product values
$product_optie = array(
    'optie_id' => '',
    'optie_titel' => '',
    'optie_naam' => '',
    'eenheidsprijs' => '',
    'product_id' => ''
);

if (isset($_GET['optie_id'])) {
    // Get product_opties van database
    $stmt = $pdo_function->prepare('SELECT * FROM product_opties WHERE optie_id = ?');
    $stmt->execute([$_GET['optie_id']]);
    $product_optie = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['submit'])) {
        // Update product_opties
        $stmt = $pdo_function->prepare('UPDATE product_opties SET optie_titel = ?, optie_naam = ?, eenheidsprijs = ?, product_id = ? WHERE optie_id = ?');
        $stmt->execute([$_POST['optie_titel'], $_POST['optie_naam'], $_POST['eenheidsprijs'], $_POST['product_id'], $_GET['optie_id']]);
        header('Location: product-opties.php?product_id=' . $_POST['product_id']);
        exit;
    }
    if (isset($_POST['delete'])) {
        // Delete product_opties
        $stmt = $pdo_function->prepare('DELETE FROM product_opties WHERE optie_id = ?');
        $stmt->execute([$_GET['optie_id']]);
        header('Location: opties.php');
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
    <title>Delga admin product-optie</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>


<main class="flex-shrink-0" role="main">
    <div class="container">

        <form class="needs-validation" novalidate action="" method="post" autocomplete="off">

            <div class="row">

                    <div class="input-group col-md-12"><br></div>
                    <div class="sr-only input-group col-md-2">
                        <label class="sr-only" for="optie_id">Optie_id</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-store"></i></div>
                            </div>
                            <input type="text" class="form-control" id="optie_id" name="optie_id"
                                   value="<?= $product_optie['optie_id'] ?>" placeholder="Titel" required>
                        </div>
                    </div>
                    <div class="input-group col-md-3">
                        <label class="sr-only" for="optie_titel">Titel</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-store"></i></div>
                            </div>
                            <input type="text" class="form-control" id="optie_titel" name="optie_titel"
                                   value="<?= $product_optie['optie_titel'] ?>" placeholder="Titel" maxlength="20" required>
                            <div class="invalid-feedback">Dit veld is verplicht.</div>
                        </div>
                    </div>

                    <div class="input-group col-md-3">
                        <label class="sr-only" for="optie_naam">Naam</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="far fa-image"></i></div>
                            </div>
                            <input type="text" class="form-control" id="optie_naam" name="optie_naam"
                                   value="<?= $product_optie['optie_naam'] ?>" placeholder="Naam" maxlength="20" required>
                            <div class="invalid-feedback">Dit veld is verplicht.</div>
                        </div>
                    </div>

                    <div class="input-group col-md-2">
                        <label class="sr-only" for="product_id">product_id</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-info"></i></div>
                            </div>
                            <input type="text" class="form-control" id="product_id" name="product_id"
                                   value="<?= $product_optie['product_id'] ?>" placeholder="Product_id" maxlength="4" required>
                            <div class="invalid-feedback">Dit veld is verplicht.</div>
                        </div>
                    </div>


                    <div class="input-group col-md-2">
                        <label class="sr-only" for="eenheidsprijs">Eenheidsprijs</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-euro-sign"></i></div>
                            </div>
                            <input type="text" class="form-control" id="eenheidsprijs" name="eenheidsprijs"
                                   value="<?= $product_optie['eenheidsprijs'] ?>"
                                   placeholder="Prijs" required>
                        </div>
                    </div>


                <div class="input-group col-md-12"><br></div>
                <div class="col-12">
                    <a class="btn btn-secondary" href="opties.php" role="button"><i class="fas fa-times"></i>
                        Annuleer</a>
                    <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-check"></i> Opslaan
                    </button>
                    <button type="submit" name="delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Verwijder</button>
                </div>
            </div>
        </form>
    </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
