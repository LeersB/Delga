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

$option = array(
    'optie_id' => '',
    'optie_titel' => '',
    'optie_naam' => '',
    'eenheidsprijs' => '',
    'product_id' => ''
);
$product = [
    'options' => [],
    'options_string' => ''
];
// Add product options to the database
function addProductOptions($pdo_function, $product_id) {
    if (isset($_POST['options'])) {
        $list = explode(',', $_POST['options']);
        $stmt = $pdo_function->prepare('SELECT * FROM product_opties WHERE product_id = ?');
        $stmt->execute([ $_GET['optie_id'] ]);
        $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $remove_list = [];
        foreach ($options as $option) {
            $option_string = $option['optie_titel'] . '__' . $option['optie_naam'] . '__' . $option['eenheidsprijs'];
            if (!in_array($option_string, $list)) {
                $remove_list[] = $option['optie_id'];
            } else {
                array_splice($list, array_search($option_string, $list), 1);
            }
        }
        $in = str_repeat('?,', count($remove_list) - 1) . '?';
        $stmt = $pdo_function->prepare('DELETE FROM product_opties WHERE optie_id IN (' . $in . ')');
        $stmt->execute($remove_list);
        foreach ($list as $option) {
            if (empty($option)) continue;
            $option = explode('__', $option);
            $stmt = $pdo_function->prepare('INSERT INTO product_opties (optie_titel,optie_naam,eenheidsprijs,product_id) VALUES (?,?,?,?)');
            $stmt->execute([ $option[0], $option[1], $option[2], $product_id ]);
        }
    }
}
if (isset($_GET['product_id'])) {
    // ID param exists, edit an existing product
    $page = 'Edit';
   // if (isset($_POST['submit'])) {
        // Update the product
        //$stmt = $pdo_function->prepare('UPDATE products SET name = ?, description = ?, price = ?, rrp = ?, quantity = ?, img = ?, date_added = ? WHERE id = ?');
        //$stmt->execute([ $_POST['name'], $_POST['description'], $_POST['price'], $_POST['rrp'], $_POST['quantity'], $_POST['main_image'], date('Y-m-d H:i:s', strtotime($_POST['date'])), $_GET['id'] ]);
        //addProductOptions($pdo_function, $_GET['product_id']);
        //header('Location: optie.php');
        //exit;
  //  }
    if (isset($_POST['delete'])) {
        // Delete the product and its images, categories, options
        $stmt = $pdo_function->prepare('DELETE p, po FROM producten p LEFT JOIN product_opties po ON po.product_id = p.product_id WHERE p.product_id = ?');
        $stmt->execute([ $_GET['product_id'] ]);
        header('Location: optie.php');
        exit;
    }
    // Get the product and its images from the database
    $stmt = $pdo_function->prepare('SELECT * FROM producten WHERE product_id = ? GROUP BY product_id');
    $stmt->execute([ $_GET['product_id'] ]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Get the product options
    $stmt = $pdo_function->prepare('SELECT * FROM product_opties WHERE product_id = ?');
    $stmt->execute([ $_GET['product_id'] ]);
    $product['options'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $product['options_string'] = '';
    foreach($product['options'] as $option) {
        $product['options_string'] .= $option['optie_titel'] . '__' . $option['optie_naam'] . '__' . $option['eenheidsprijs'] . ',';
    }
    $product['options_string'] = rtrim($product['options_string'], ',');
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
            <div class="content-block">
                <div class="row" id="content-wrapper">
                    <div class="col-md">

                    </div>
                </div>
            </div>

            <label for="add_option">Options</label>
            <div style="display:flex;flex-flow:wrap;">
                <input type="text" name="optie_titel" placeholder="Option Title" >
                <input type="text" name="optie_naam" placeholder="Option Name" >
                <input type="number" name="eenheidsprijs" min="0" step=".01" placeholder="Option Price">
                <button id="add_option">Add</button>
                <select name="options" multiple>
                    <?php foreach ($product['options'] as $option): ?>
                        <option value="<?=$option['optie_titel']?>__<?=$option['optie_naam']?>__<?=$option['eenheidsprijs']?>"><?=$option['optie_titel']?>,<?=$option['optie_naam']?>,<?=$option['eenheidsprijs']?></option>
                    <?php endforeach; ?>
                </select>
                <button id="remove_selected_options">Remove</button>
                <input type="hidden" name="options" value="<?=$product['options_string']?>">
            </div>

            <div class="row">
                <?php foreach ($product['options'] as $optie): ?>
                <div class="input-group col-md-12"><br></div>
                    <div class="sr-only input-group col-md-2">
                        <label class="sr-only" for="optie_id">Optie_id</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-store"></i></div>
                            </div>
                            <input type="text" class="form-control" id="optie_id" name="optie_od"
                                   value="<?= $optie['optie_id'] ?>" placeholder="Titel" required>
                        </div>
                    </div>
                <div class="input-group col-md-3">
                    <label class="sr-only" for="optie_titel">Titel</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-store"></i></div>
                        </div>
                        <input type="text" class="form-control" id="optie_titel" name="optie_titel"
                               value="<?= $optie['optie_titel'] ?>" placeholder="Titel" maxlength="20" required>
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
                               value="<?= $optie['optie_naam'] ?>" placeholder="Naam" maxlength="20" required>
                        <div class="invalid-feedback">Dit veld is verplicht.</div>
                    </div>
                </div>

                <div class="sr-only input-group col-md-2">
                    <label class="sr-only" for="product_id">product_id</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-info"></i></div>
                        </div>
                        <input type="text" class="form-control" id="product_id" name="product_id"
                               value="<?= $optie['product_id'] ?>" placeholder="Product_id" maxlength="4" required>
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
                                   value="<?= $optie['eenheidsprijs'] ?>"
                                   placeholder="Prijs" required>
                        </div>
                    </div>


                    <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-check"></i> Opslaan</button>
                    <button type="submit" name="delete" class="btn btn-danger">Verwijder</button>

                <?php endforeach; ?>
                <div class="input-group col-md-12"><br></div>
                <div class="col-12">
                    <a class="btn btn-secondary" href="producten.php" role="button"><i class="fas fa-times"></i> Annuleer</a>
                </div>
            </div>
        </form>
    </div>

    </div>
</main>

<?php include('includes/footer.php'); ?>
<script>
    document.querySelector("#remove_selected_options").onclick = function(e) {
        e.preventDefault();
        document.querySelectorAll("select[name='options'] option").forEach(function(option) {
            if (option.selected) {
                let list = document.querySelector("input[name='options']").value.split(",");
                list.splice(list.indexOf(option.value), 1);
                document.querySelector("input[name='options']").value = list.join(",");
                option.remove();
            }
        });
    };
    document.querySelector("#add_option").onclick = function(e) {
        e.preventDefault();
        if (document.querySelector("input[name='optie_titel']").value === "") {
            document.querySelector("input[name='optie_titel']").focus();
            return;
        }
        if (document.querySelector("input[name='optie_naam']").value === "") {
            document.querySelector("input[name='optie_naam']").focus();
            return;
        }
        if (document.querySelector("input[name='eenheidsprijs']").value === "") {
            document.querySelector("input[name='eenheidsprijs']").focus();
            return;
        }
        let option = document.createElement("option");
        option.value = document.querySelector("input[name='optie_titel']").value + '__' + document.querySelector("input[name='optie_naam']").value + '__' + document.querySelector("input[name='eenheidsprijs']").value;
        option.text = document.querySelector("input[name='optie_titel']").value + ',' + document.querySelector("input[name='optie_naam']").value + ',' + document.querySelector("input[name='eenheidsprijs']").value;
        document.querySelector("select[name='options']").add(option);
        document.querySelector("input[name='optie_titel']").value = "";
        document.querySelector("input[name='optie_naam']").value = "";
        document.querySelector("input[name='eenheidsprijs']").value = "";
        document.querySelectorAll("select[name='options'] option").forEach(function(option) {
            let list = document.querySelector("input[name='options']").value.split(",");
            if (!list.includes(option.value)) {
                list.push(option.value);
            }
            document.querySelector("input[name='options']").value = list.join(",");
        });
    };
</script>
</body>
</html>
