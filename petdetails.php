<?php
        include 'viewprofile.php';
        include 'check_user.php';
include 'fetch_userProfile.php';

        $fetch_user = "SELECT * FROM userprofile WHERE user_id = $userID";
        $fetch = mysqli_query($conn, $fetch_user);
        $data = mysqli_fetch_assoc($fetch);
        $userName = $data['user_name'];
        $userEmail = $data['user_email'];
        $userPhone = $data['user_phone'];
        $userAddress = $data['user_address'];
        if($is_logged_in){
            $fav_result = mysqli_query($conn, "SELECT * FROM favourites WHERE user_id = $userId AND pet_id = $pet_id");
            $isfavourite = mysqli_num_rows($fav_result) > 0;
        }
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peternity</title>
    <link rel="shortcut icon" href="Assets\images\petlogo-fav.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/css/navbar.css">
    <style>
    .detail-card {
        border: none;
        border-radius: 15px;
    }

    .gender-icon {
        font-size: 1.2rem;
        vertical-align: middle;
    }

    .section-title {
        color: #198754;
        border-bottom: 2px solid #DFFBF3;
        padding-bottom: 0.5rem;
    }

    .pet-image-container {
        height: 360px;
        background-color: #f8f9fa;
        border-radius: 15px;
        overflow: hidden;
    }

    .pet-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .favs {

        outline: none;
        /* border: none; */
        background: transparent;
    }

    .disabled-link {
        pointer-events: none;
        border: none;
        background-color: #999;
        text-decoration: none;
        cursor: default;
    }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">


        <div class="card detail-card shadow-lg">
            <div class="card-header text-center" style="background-color: #DFFBF3;">
                <h1 class="mb-0"><?= $petName ?>'s Profile</h1>
            </div>

            <div class="card-body p-5">
                <!-- Back Button -->
                <a href="petlist.php" class="btn btn-outline-secondary mb-4">
                    ← Back to Listings
                </a>

                <!-- Pet Basic Info Section -->
                <div class="row g-5 mb-5">
                    <div class="col-md-5">
                        <div class="pet-image-container">
                            <img src="Assets/uploads/<?= $imgprofile ?? 'default-pet.jpg' ?>" alt="<?= $petName ?>"
                                onerror="this.src='Assets/images/default-pet.jpg'">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="h-100 d-flex flex-column justify-content-center">
                            <h2 class="mb-4 section-title">Basic Information</h2>
                            <dl class="row fs-5">
                                <dt class="col-sm-4">Name</dt>
                                <dd class="col-sm-8"><?= $petName ?></dd>

                                <dt class="col-sm-4">Species</dt>
                                <dd class="col-sm-8"><?= $species ?></dd>

                                <?php if($age): ?>
                                <dt class="col-sm-4">Age</dt>
                                <dd class="col-sm-8"><?= $age ?> years</dd>
                                <?php endif; ?>

                                <dt class="col-sm-4">Gender</dt>
                                <dd class="col-sm-8">
                                    <?php if($gender === 'Male'): ?>
                                    <span class="gender-icon">♂</span> Male
                                    <?php elseif($gender === 'Female'): ?>
                                    <span class="gender-icon">♀</span> Female
                                    <?php else: ?>
                                    Unknown
                                    <?php endif; ?>
                                </dd>
                                <?php if($is_logged_in): ?>
                                <form action="favourites.php" method="POST">
                                    <input type="hidden" name="pet_id" value="<?= htmlspecialchars($pet_id) ?>">
                                    <?php if ($isfavourite): ?>
                                    <button type="submit" name="action" value="remove" class="favs"><i
                                            class="fa-solid fa-heart"></i></button>
                                    <?php else: ?>
                                    <button type="submit" name="action" value="add" class="favs"><i
                                            class="fa-regular fa-heart"></i></button>
                                    <?php endif; ?>
                                </form>
                                <?php else: ?>
                                <p><a href="login.php">Log in</a> to add this pet to your favourites.</p>
                                <?php endif; ?>

                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Description & Health Section -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="p-4 bg-white rounded-3 shadow-sm">
                            <h3 class="mb-3 section-title">Description</h3>
                            <p class="text-muted lh-lg"><?= $petBio ?></p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-4 bg-white rounded-3 shadow-sm">
                            <h3 class="mb-3 section-title">Health Information</h3>
                            <p class="text-muted lh-lg"><?= $healthInfo ?></p>
                        </div>
                    </div>
                </div>

                <!-- Owner Details Section -->
                <div class="bg-white p-4 rounded-3 shadow-sm">
                    <h2 class="mb-4 section-title">Owner Information</h2>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <dl class="row fs-5">
                                <dt class="col-sm-4">Name</dt>
                                <dd class="col-sm-8"><?= $userName ?></dd>

                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">
                                    <?= $userEmail ?>
                                </dd>

                                <?php if($userPhone): ?>
                                <dt class="col-sm-4">Phone</dt>
                                <dd class="col-sm-8">

                                    <?= $userPhone ?>

                                </dd>
                                <?php endif; ?>

                                <dt class="col-sm-4">Location</dt>
                                <dd class="col-sm-8"><?= $userAddress ?></dd>
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <h4 class="h5 text-muted mb-3">Rehoming Reason</h4>
                                <blockquote class="blockquote m-0">
                                    <p class="fst-italic text-secondary">
                                        <?= $reason ?>
                                    </p>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-5">
                    <?php if($is_logged_in): ?>
                    <?php if($userId == $userID || $is_adopted == 1): ?>
                    <a href="apply_adoption.php?i=<?= $pet_id ?>" onclick="return false;"
                        class="btn btn-success rounded-pill px-5 disabled-link">Apply for
                        Adoption</a>
                    <?php else: ?>
                    <a href="apply_adoption.php?i=<?= $pet_id ?>" class="btn btn-success rounded-pill px-5">Apply for
                        Adoption</a>
                    <?php endif; ?>
                    <?php else: ?>
                    <a href="login.php" class="btn btn-primary rounded-pill px-5">Apply for
                        Adoption</a>
                    <?php endif; ?>
                    <!-- < if (!$pet['adopted'] && $is_logged_in): ?>
                    <form method="POST" action="apply_adoption.php">
                        <input type="hidden" name="pet_id" value="< $pet['pet_id'] ?>">
                        <button type="submit" class="btn btn-success">Apply for Adoption</button>
                    </form>
                    < elseif (!$is_logged_in): ?>
                    <p><a href="login.php">Login</a> to apply for adoption.</p>
                    < endif; ?> -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>