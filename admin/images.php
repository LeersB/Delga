<?php
$menuadmin = 3;
include '../admin/main.php';
$error = '';
if (isset($_FILES['upload_images'])) {
    $upload_images = $_FILES['upload_images'];
    $fileCount = count($upload_images['name']);
    for ($i = 0; $i < $fileCount; $i++) {
        if (file_exists('../images/producten/' . $upload_images['name'][$i])) {
            $error .= 'Er bestaat reeds een afbeelding met deze naam: <b>' . $upload_images['name'][$i] . '</b><br>';
        } else {
            move_uploaded_file($upload_images['tmp_name'][$i], '../images/producten/' . $upload_images['name'][$i]);
        }
    }
}
if (isset($_GET['delete']) && file_exists('../images/producten/' . $_GET['delete'])) {
    unlink('../images/producten/' . $_GET['delete']);
}
$imgs = glob('../images/producten/*.{jpg,png,gif,jpeg,webp}', GLOB_BRACE);
?>
<!DOCTYPE html>
<html class="h-100" lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
        <meta content="Delga contactgegevens" name="description">
        <meta content="Bart Leers" name="author">
        <title>Delga admin images</title>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../css/delga-admin.css" rel="stylesheet">
    </head>

    <body class="d-flex flex-column h-100">

        <header>
            <?php include('../admin/includes/header.php'); ?>
        </header>

        <main class="flex-shrink-0">
            <div class="container">

                <p class="error"><?= $error ?></p>
                <form action="images.php" method="post" class="form input-group" enctype="multipart/form-data">
                    <div class="input-group col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="upload_images[]" id="images"
                                   aria-describedby="images" multiple required>
                            <label class="custom-file-label" for="images">Bestand kiezen</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="images_submit">Uploaden</button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="input-group col-md-12"><br></div>
                    <?php foreach ($imgs as $img): ?>
                        <div class="card text-right col-md-3">
                            <a href="images.php?delete=<?= basename($img) ?>"><i class="fas fa-times"></i></a>
                            <img src="<?= $img ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text"><small><?= basename($img) ?></small></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="input-group col-md-12"><br></div>
                </div>

            </div>
        </main>

        <?php include('../admin/includes/footer.php'); ?>

        <script>
            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function () {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        </script>
    </body>
</html>