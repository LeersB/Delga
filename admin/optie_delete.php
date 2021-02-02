<?php
$menuadmin = 3;
include 'main.php';
$pdo_function = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['optie_id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo_function->prepare('SELECT * FROM product_opties WHERE optie_id = ?');
    $stmt->execute([$_GET['optie_id']]);
    $optie = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$optie) {
        exit('Er bestaat geen optie met dit ID nummer!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo_function->prepare('DELETE FROM product_opties WHERE optie_id = ?');
            $stmt->execute([$_GET['optie_id']]);
            $msg = 'Optie is verwijdert!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: opties.php');
            exit;
        }
    }
} else {
    exit('Geen ID opgegeven!');
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


        <div class="content delete">
            <h2>Product optie #<?= $optie['optie_id'] ?> verwijderen</h2>
            <?php if ($msg): ?>
                <p><?= $msg ?></p>
            <?php else: ?>
                <p>Ben je zeker dat je product optie #<?= $optie['optie_id'] ?> <?= $optie['optie_titel'] ?>-<?= $optie['optie_naam'] ?> wilt verwijderen?</p>
                <div class="yesno">
                    <a class="btn btn-secondary" href="optie_delete.php?optie_id=<?= $optie['optie_id'] ?>&confirm=no"><i class="fas fa-times"></i> Annuleer</a>
                    <a class="btn btn-danger" href="optie_delete.php?optie_id=<?= $optie['optie_id'] ?>&confirm=yes"><i class="fas fa-trash-alt"></i> Verwijder</a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
