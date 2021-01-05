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
        <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit"><i class="fas fa-shopping-basket"></i>
        </button>
    </div>
    <div class="btn-group mr-2">
        <a class="btn btn-sm-0 btn-outline-secondary" href="profiel.php"></span><i class="fas fa-user-circle"></i>
            Profiel</a>
    </div>
    <div class="btn-group mr-2">
        <a class="btn btn-sm-0 btn-outline-secondary" href="logout.php"></span><i
                    class="fas fa-sign-out-alt"></i> Afmelden</a>
    </div>
</form>