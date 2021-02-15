<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
    <a class="navbar-brand" href="index.php"><img alt="" height="40" src="images/delga_gif.gif" width="75"></a>
    <button aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
            data-target="#navbar"
            data-toggle="collapse" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
            <?php
            switch ($menu) {
                case 1: //
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home <span
                                    class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info.php"><i class="fas fa-info"></i> Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="producten.php"><i class="fas fa-store"></i> Producten</a>
                    </li>
                    <?php
                    break;
                case 2: //
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="info.php"><i class="fas fa-info"></i> Info<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="producten.php"><i class="fas fa-store"></i> Producten</a>
                    </li>
                    <?php
                    break;
                case 3: //
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info.php"><i class="fas fa-info"></i> Info</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="producten.php"><i class="fas fa-store"></i> Producten<span
                                    class="sr-only">(current)</span></a>
                    </li>
                    <?php
                    break;
                case 4: //
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info.php"><i class="fas fa-info"></i> Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="producten.php"><i class="fas fa-store"></i> Producten</a>
                    </li>
                    <?php
                    break;
                case 5: //
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info.php"><i class="fas fa-info"></i> Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="producten.php"><i class="fas fa-store"></i> Producten</a>
                    </li>
                    <?php if ($_SESSION['user_level'] == 'Admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/index.php" target="_blank"><i class="fas fa-user-cog"></i> Admin</a>
                    </li>

                <?php endif;
                    break;
            }
            ?>
        </ul>

        <?php
        if (isset($_SESSION['loggedin'])) {
            include('includes/header_logout.php');
        } else {
            include('includes/header_login.php');
        }
        ?>

    </div>
</nav>
