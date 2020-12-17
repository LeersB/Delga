<?php
include 'main.php';
$stmt = $pdo->prepare('SELECT * FROM users');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_admin_header('Accounts') ?>

<h2>Accounts</h2>

<div class="links">
    <a href="users.php">Create Account</a>
</div>

<div class="content-block">
    <div class="table">

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">E-mailadres</th>
                <th scope="col">Naam</th>
                <th scope="col">Adres</th>
                <th scope="col">Activatie</th>
                <th scope="col">Level</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no accounts</td>
                </tr>
            <?php else: ?>
     <?php foreach ($users as $user): ?>
                    <tr class="details" onclick="location.href='users.php?user_id=<?= $user['user_id']?>'">
                        <td><?= $user['user_id'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td class="responsive-hidden"><?= $user['voornaam']," ", $user['achternaam'] ?></td>
                        <td class="responsive-hidden"><?= $user['adres_straat'], " ",$user['adres_nr'], " ", $user['adres_postcode'], " ", $user['adres_plaats']?></td>
                        <td class="responsive-hidden"><?= $user['activatie_code'] ?></td>
                        <td class="responsive-hidden"><?= $user['user_level'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= template_admin_footer() ?>
