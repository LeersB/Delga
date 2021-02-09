<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="../index.php"><img alt="" height="40" src="../images/delga_gif.gif" width="75"></a>
    <button aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
            data-target="#navbar" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">

            <?php
            switch ($menuadmin) {
                case 1: //
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home<span
                                    class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="ordersDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-mail-bulk"></i> Orders
                        </a>
                        <div class="dropdown-menu" aria-labelledby="ordersDropdown">
                            <a class="dropdown-item" href="orders.php"><i class="fas fa-mail-bulk"></i> Raadplegen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="order-details.php"><i class="fas fa-list-ol"></i> Raadplegen</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users"></i> Users
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="users.php"><i class="fas fa-users"></i> Raadplegen</a>
                            <a class="dropdown-item" href="user.php"><i class="fas fa-user"></i> Toevoegen</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="productDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-store"></i> Producten
                        </a>
                        <div class="dropdown-menu" aria-labelledby="productDropdown">
                            <a class="dropdown-item" href="producten.php"><i class="fas fa-store"></i> Raadplegen</a>
                            <a class="dropdown-item" href="product.php"><i class="fas fa-pump-soap"></i> Toevoegen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="images.php"><i class="far fa-image"></i> Afbeeldingen</a>
                            <a class="dropdown-item" href="opties.php"><i class="fas fa-cart-plus"></i> Opties</a>
                            <a class="dropdown-item" href="categories.php"><i class="fas fa-list-ol"></i> Categorieën</a>
                        </div>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link" href="settings.php"><i class="fas fa-tools"></i> Settings</a>
                    </li>-->
                    <?php
                    break;
                case 2: //
                    ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="ordersDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-mail-bulk"></i> Orders
                        </a>
                        <div class="dropdown-menu" aria-labelledby="ordersDropdown">
                            <a class="dropdown-item" href="orders.php"><i class="fas fa-mail-bulk"></i> Raadplegen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="order-details.php"><i class="fas fa-list-ol"></i> Raadplegen</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users"></i> Users<span
                                    class="sr-only">(current)</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="users.php"><i class="fas fa-users"></i> Raadplegen</a>
                            <a class="dropdown-item" href="user.php"><i class="fas fa-user"></i> Toevoegen</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="productenDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-store"></i> Producten
                        </a>
                        <div class="dropdown-menu" aria-labelledby="productenDropdown">
                            <a class="dropdown-item" href="producten.php"><i class="fas fa-store"></i> Raadplegen</a>
                            <a class="dropdown-item" href="product.php"><i class="fas fa-pump-soap"></i> Toevoegen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="images.php"><i class="far fa-image"></i> Afbeeldingen</a>
                            <a class="dropdown-item" href="opties.php"><i class="fas fa-cart-plus"></i> Opties</a>
                            <a class="dropdown-item" href="categories.php"><i class="fas fa-list-ol"></i> Categorieën</a>
                        </div>
                    </li>
                    <?php
                    break;
                case 3: //
                    ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="ordersDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-mail-bulk"></i> Orders
                        </a>
                        <div class="dropdown-menu" aria-labelledby="ordersDropdown">
                            <a class="dropdown-item" href="orders.php"><i class="fas fa-mail-bulk"></i> Raadplegen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="order-details.php"><i class="fas fa-list-ol"></i> Raadplegen</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users"></i> Users
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="users.php"><i class="fas fa-users"></i> Raadplegen</a>
                            <a class="dropdown-item" href="user.php"><i class="fas fa-user"></i> Toevoegen</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" id="productenDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-store"></i> Producten<span
                                    class="sr-only">(current)</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="productenDropdown">
                            <a class="dropdown-item" href="producten.php"><i class="fas fa-store"></i> Raadplegen</a>
                            <a class="dropdown-item" href="product.php"><i class="fas fa-pump-soap"></i> Toevoegen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="images.php"><i class="far fa-image"></i> Afbeeldingen</a>
                            <a class="dropdown-item" href="opties.php"><i class="fas fa-cart-plus"></i> Opties</a>
                            <a class="dropdown-item" href="categories.php"><i class="fas fa-list-ol"></i> Categorieën</a>
                        </div>
                    </li>
                    <?php
                    break;
                case 4: //
                    ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" id="ordersDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-mail-bulk"></i> Orders<span
                                    class="sr-only">(current)</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="ordersDropdown">
                            <a class="dropdown-item" href="orders.php"><i class="fas fa-mail-bulk"></i> Raadplegen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="order-details.php"><i class="fas fa-list-ol"></i> Raadplegen</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users"></i> Users
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="users.php"><i class="fas fa-users"></i> Raadplegen</a>
                            <a class="dropdown-item" href="user.php"><i class="fas fa-user"></i> Toevoegen</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="productenDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-store"></i> Producten
                        </a>
                        <div class="dropdown-menu" aria-labelledby="productenDropdown">
                            <a class="dropdown-item" href="producten.php"><i class="fas fa-store"></i> Raadplegen</a>
                            <a class="dropdown-item" href="product.php"><i class="fas fa-pump-soap"></i> Toevoegen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="images.php"><i class="far fa-image"></i> Afbeeldingen</a>
                            <a class="dropdown-item" href="opties.php"><i class="fas fa-cart-plus"></i> Opties</a>
                            <a class="dropdown-item" href="categories.php"><i class="fas fa-list-ol"></i> Categorieën</a>
                        </div>
                    </li>
                    <?php
                    break;
            }
            ?>
        </ul>
        <form class="form-inline mt-2 mt-sm-2" action="zoeken.php" method="get">
            <div class="input-group mr-sm-2">
                <input type="text" class="form-control" name="query" placeholder="Product zoeken" aria-label="Product zoeken"
                       aria-describedby="button-addon"
                       value="<?= isset($_GET['query']) ? htmlentities($_GET['query'], ENT_QUOTES) : '' ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <form class="form-inline mt-2 mt-sm-2">
            <div class="btn-group mr-2">
                <a class="btn btn-sm-0 btn-outline-secondary" href="../logout.php"></span><i
                            class="fas fa-sign-out-alt"></i> Afmelden</a>
            </div>
        </form>


    </div>
</nav>