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

        <form class="d-flex mt-2" action="zoeken.php" method="get">
            <div class="input-group mr-2">
                <input type="text" class="form-control" name="query" placeholder="Product zoeken"
                       aria-label="Product zoeken"
                       value="<?= isset($_GET['query']) ? htmlentities($_GET['query'], ENT_QUOTES) : '' ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <div class="d-flex mt-2">
            <div class="btn-group mr-2">
                <a class="btn btn-outline-secondary" href="winkelmand.php"><i
                            class="fas fa-shopping-basket"></i> <?= $aantal_winkelmand ?></a>
            </div>
            <?php if (isset($_SESSION['loggedin'])): ?>
                <div class="btn-group mr-2">
                    <a class="btn btn-outline-secondary" href="profiel.php"><i class="fas fa-user-circle"></i>
                        Profiel</a>
                </div>
                <div class="btn-group mr-2">
                    <a class="btn btn-outline-secondary" href="logout.php"><i class="fas fa-sign-out-alt"></i>
                        Afmelden</a>
                </div>
            <?php else: ?>
                <div class="btn-group mr-2">
                    <a class="btn btn-outline-secondary" href="login.php"><i class="fas fa-sign-in-alt"></i>
                        Aanmelden</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>