<?php
include 'main.php';
$pdo_function = pdo_connect_mysql();
$stmt = $pdo_function->prepare('SELECT * FROM producten');
$stmt->execute();
$producten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_admin_header('Producten') ?>

<h2>Producten</h2>

<div class="links">
    <a href="product.php">Create</a>
</div>

<div class="content-block">
    <div class="table">

        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Categorie id</th>
                <th scope="col">Naam</th>
                <th scope="col">Foto</th>
                <th scope="col">Prijs</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($producten)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no accounts</td>
                </tr>
            <?php else: ?>
                <?php foreach ($producten as $user): ?>
                    <tr class="details" onclick="location.href='producten.php?product_id=<?= $user['product_id']?>'">
                        <td><?= $user['product_id'] ?></td>
                        <td><?= $user['categorie_id'] ?></td>
                        <td><?= $user['product_naam'] ?></td>
                        <td class="responsive-hidden"><?= $user['product_foto'] ?></td>
                        <td><?= $user['eenheidsprijs'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= template_admin_footer() ?>
