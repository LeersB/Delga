<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #C5D3CE;">
    <a class="navbar-brand" href="../index.php"><img alt="" height="40" src="../images/delga_gif.gif" width="75"></a>
    <button aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
            data-target="#navbar" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home <span
                        class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users.php"><i class="fas fa-users"></i> Users</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="productenDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-store"></i> Producten
                </a>
                <div class="dropdown-menu" aria-labelledby="productenDropdown">
                    <a class="dropdown-item" href="producten.php">Raadplegen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="images.php"><i class="far fa-image"></i> Afbeeldingen</a>
                    <a class="dropdown-item" href="#">Opties</a>
                </div>
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
                <a class="btn btn-sm-0 btn-outline-secondary" href="../logout.php"></span><i class="fas fa-sign-out-alt"></i> Afmelden</a>
            </div>
        </form>
    </div>
</nav>