<?php
    include 'fetch_userProfile.php';
?>

<nav class="navbar sticky-top navbar-expand-lg navbar-light">
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
        <div class="d-flex ps-4 ">
            <a href="userprofile.php">
                <img src="Assets/uploads/<?= $userImage ?? 'default-pet.jpg' ?>" id="userprofile" width="52" height="52"
                    alt="Adopter" onerror="this.src='Assets/images/default-pet.jpg'" />
            </a>
        </div>

    </div>
</nav>