<?php
$menuadmin = 2;
include 'main.php';
$pdo_function = pdo_connect_mysql();
$stmt = $pdo_function->prepare('SELECT * FROM users');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Delga contactgegevens" name="description">
    <meta content="Bart Leers" name="author">
    <title>Delga admin user</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/delga.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<header>
    <?php include('includes/header.php'); ?>
</header>


<main class="flex-shrink-0" role="main">
    <div class="container">

        <h2>Users</h2>

        <div class="content table-responsive-lg">
            <table class="table table-success table-hover table-borderless">
                <thead class="table-light">
                <tr>
                    <th scope="col">E-mailadres</th>
                    <th scope="col">Naam</th>
                    <th scope="col">Facturatieadres</th>
                    <th scope="col">Leveringsadres</th>
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
                        <tr class="details" onclick="location.href='user.php?user_id=<?= $user['user_id'] ?>'">
                            <td><?= $user['email'] ?></td>
                            <td class="responsive-hidden"><?= $user['voornaam'], " ", $user['achternaam'] ?></td>
                            <td class="responsive-hidden"><?= $user['adres_straat'], " ", $user['adres_nr'], " ", $user['adres_postcode'], " ", $user['adres_plaats'] ?></td>
                            <td class="responsive-hidden"><?= $user['adres_straat_2'], " ", $user['adres_nr_2'], " ", $user['adres_postcode_2'], " ", $user['adres_plaats_2'] ?></td>
                            <td class="responsive-hidden"><?= $user['user_level'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
