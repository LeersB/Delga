<?php
// Include the root "main.php" file and check if user is logged-in...
include_once '../config.php';
include_once '../main.php';
$pdo_function = pdo_connect_mysql();
check_loggedin($pdo_function, '../index.php');
$stmt = $pdo_function->prepare('SELECT * FROM users WHERE user_id = ?');
$stmt->execute([ $_SESSION['user_id'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if the user is an admin...
if ($account['user_level'] != 'Admin') {
    exit('You do not have permission to access this page!');
}
// Template admin header
function template_admin_header($title)
{
    echo <<<EOT
<!DOCTYPE html>
<html class="h-100" lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>$title</title>
		<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="../css/delga.css" rel="stylesheet" type="text/css">
	</head>
	
	<body class="admin d-flex flex-column h-100">
	<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #C5D3CE;">
    <a class="navbar-brand" href="../index.php"><img alt="" height="40" src="../images/delga_gif.gif" width="75"></a>
    <button aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
            data-target="#navbar" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
             <li class="nav-item active">
                  <a class="nav-link" href="../index.php"><i class="fas fa-home"></i> Home <span
                                    class="sr-only">(current)</span></a>
             </li>
                <li class="nav-item">
                 <a class="nav-link" href="index.php"><i class="fas fa-users"></i> Users</a>
             </li>
                  <li class="nav-item">
                 <a class="nav-link" href="producten.php"> Producten</a>
             </li>
                <li class="nav-item">
                 <a class="nav-link" href="settings.php"><i class="fas fa-tools"></i> Settings</a>
             </li>
        </ul>
<form class="form-inline mt-2 mt-md-0">
<div class="input-group mr-sm-2">
        <input type="text" class="form-control" placeholder="Account zoeken" aria-label="Product zoeken" aria-describedby="button-addon">
        <div class="input-group-append">
            <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <div class="btn-group mr-2">
        <a class="btn btn-sm-0 btn-outline-secondary" href="../profiel.php"></span><i class="fas fa-user-circle"></i> Profiel</a>
    </div>
    <div class="btn-group mr-2">
        <a class="btn btn-sm-0 btn-outline-secondary" href="../logout.php"></span><i
                    class="fas fa-sign-out-alt"></i> Afmelden</a>
    </div>
</form>

    </div>
</nav>

     <main class="flex-shrink-0" role="main">
    <div class="container">

EOT;
}

// Template admin footer
function template_admin_footer()
{
    echo <<<EOT
</div>
        </main>
        <footer class="bg-white text-dark mt-auto py-2">
    <div class="modal-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto mr-auto"><a href="http://www.mxguarddog.com/"><img src="../images/mxguarddog.gif"
                                                                                        class="figure-img rounded"
                                                                                        alt="anti spam"
                                                                                        style="width:35%"></a></div>
                <p>Laatst aangepast 10/12/2020</p>
                <div class="col-auto">
                    <address>
                        <h5>Bart Leers &copy; 2021 </h5>
                    </address>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/2878681c2b.js" crossorigin="anonymous"></script>
    </body>
</html>
EOT;
}

?>
