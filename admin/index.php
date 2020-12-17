<?php

include 'main.php';
// query to get all accounts from the database
$stmt = $con->prepare('SELECT user_id, voornaam, achternaam, email, adres_straat, adres_nr, adres_postcode, adres_plaats, activatie_code, user_level FROM users');
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($user_id, $voornaam, $achternaam, $email, $adres_straat, $adres_nr, $adres_postcode, $adres_plaats, $activatie_code, $user_level);
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
            <?php if ($stmt->num_rows == 0): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no accounts</td>
                </tr>
            <?php else: ?>
                <?php while ($stmt->fetch()): ?>
                    <tr class="details" onclick="location.href='users.php?user_id=<?= $user_id ?>'">
                        <td><?= $user_id ?></td>
                        <td><?= $email ?></td>
                        <td class="responsive-hidden"><?= $voornaam," ", $achternaam ?></td>
                        <td class="responsive-hidden"><?= $adres_straat, " ",$adres_nr, " ", $adres_postcode, " ", $adres_plaats?></td>
                        <td class="responsive-hidden"><?= $activatie_code ?></td>
                        <td class="responsive-hidden"><?= $user_level ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= template_admin_footer() ?>
