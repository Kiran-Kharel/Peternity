<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid w-100 h-100">
        <a class="navbar-brand" href="index.php">
            <img src="Assets/images/petlogo.png" alt="Logo">
        </a>

        <div class="d-flex justify-content-center flex-grow-1 mx-4">
            <form class="d-flex searchbar" method="GET" action="petlist.php">
                <input class="form-control me-2 rounded-pill" name="q" type="search" placeholder="Search for Pet"
                    value="<?= (isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '')?>" aria-label="Search">
                <button class="btn btn-outline-success rounded-pill" type="submit"><i
                        class="fa-solid fa-magnifying-glass"></i> </button>
            </form>
        </div>

        <div class="d-flex cta-rehome">
            <a href="rehome.php" class="btn btn-success rounded-pill">Rehome a Pet</a>
        </div>
    </div>
</nav>