<?php
$menuadmin = 3;
include '../admin/main.php';
$pdo_function = pdo_connect_mysql();

$filter_order_by = filter_input(INPUT_GET, 'order_by', FILTER_SANITIZE_STRING);
$filter_order_sort = filter_input(INPUT_GET, 'order_sort', FILTER_SANITIZE_STRING);

// Default input product values
$product = array(
    'eenheidsprijs' => '',
    'product_id' => '',
    'product_naam' => ''
);

$order_by_list = array('product_id', 'categorie_naam', 'product_naam', 'eenheidsprijs');
$order_by = isset($filter_order_by) && in_array($filter_order_by, $order_by_list) ? $filter_order_by : 'product_id';
$order_sort = isset($filter_order_sort) && $filter_order_sort == 'DESC' ? 'DESC' : 'ASC';

$stmt = $pdo_function->prepare("SELECT * FROM producten p inner join categorie c on p.categorie_id = c.categorie_id WHERE product_level = 'actief' ORDER BY " . $order_by . ' ' . $order_sort);
$stmt->execute();
$producten = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['product'])) {
    // Get product_opties van database
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = ?');
    $stmt->execute([$_POST['product']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['submit'])) {
    // Update product_opties
    $stmt = $pdo_function->prepare('UPDATE producten SET eenheidsprijs = ? WHERE product_id = ? LIMIT 1');
    $stmt->execute([$_POST['eenheidsprijs'], $_POST['product_id']]);
    header('Location: product-prijs.php');
    exit;
}
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga admin product-prijs</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga-admin.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('../admin/includes/header.php'); ?>
</header>

<main class="flex-shrink-0">
    <div class="container">

        <h2>Producten prijs wijzigen</h2>

        <?php if (isset($_POST['product'])) : ?>
            <form class="needs-validation" novalidate action="" method="post" autocomplete="off">
                <div class="row justify-content-end">
                    <div class="input-group col-md-12"><br></div>

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
                    <p>"<?= $product['product_naam'] ?>"</p>
                    <div class="input-group col-md-3">
                        <label class="sr-only" for="eenheidsprijs">Eenheidsprijs</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-euro-sign"></i></div>
                            </div>
                            <input type="text" class="form-control" id="eenheidsprijs" name="eenheidsprijs"
                                   value="<?= $product['eenheidsprijs'] ?>"
                                   placeholder="Prijs" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-secondary"
                           href="product-prijs.php" role="button"><i
                                    class="fas fa-times"></i></a>
                        <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-check"></i>
                        </button>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <div class="table-responsive-lg">
            <form class="needs-validation" novalidate action="" method="post" autocomplete="off">
                <table class="table table-success table-hover table-borderless">
                    <thead class="table-light">
                    <tr>
                        <th colspan="2">
                            <a href="product-prijs.php?order_by=product_id&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                                <i class="fas fa-hashtag"></i>
                                <?php if ($order_by == 'product_id'): ?>
                                    <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="product-prijs.php?order_by=product_naam&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                                Product naam
                                <?php if ($order_by == 'product_naam'): ?>
                                    <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="product-prijs.php?order_by=categorie_naam&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                                Categorie
                                <?php if ($order_by == 'categorie_naam'): ?>
                                    <i class="fas fa-sort-alpha-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="product-prijs.php?order_by=eenheidsprijs&order_sort=<?= $order_sort == 'ASC' ? 'DESC' : 'ASC' ?>">
                                Prijs
                                <?php if ($order_by == 'eenheidsprijs'): ?>
                                    <i class="fas fa-sort-numeric-<?= str_replace(array('ASC', 'DESC'), array('down', 'down-alt'), $order_sort) ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($producten)): ?>
                        <tr>
                            <td colspan="8" style="text-align:center;">Er zijn geen producten aanwezig</td>
                        </tr>
                    <?php else: ?>

                        <?php foreach ($producten as $product): ?>
                            <tr class="details">
                                <td><?= $product['product_id'] ?></td>
                                <td class="img">
                                    <?php if (!empty($product['product_foto']) && file_exists('../images/producten/' . $product['product_foto'])): ?>
                                        <img src="../images/producten/<?= $product['product_foto'] ?>" width="32"
                                             height="32" alt="<?= $product['product_naam'] ?>">
                                    <?php endif; ?>
                                </td>
                                <td><?= $product['product_naam'] ?></td>
                                <td><?= $product['categorie_naam'] ?></td>
                                <td>€&nbsp;<?= $product['eenheidsprijs'] ?></td>
                                <td>
                                    <button type="submit" name="product"
                                            class="btn btn-outline-success" value="<?= $product['product_id'] ?>"><i
                                                class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </form>
        </div>

    </div>
</main>

<?php include('../admin/includes/footer.php'); ?>
<script src="../js/form-validation.js"></script>
</body>
</html>