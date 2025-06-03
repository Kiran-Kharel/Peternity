<?php 
require_once 'connect.php';
require_once 'check_user.php';   
include 'check_session.php';  

$imgdir = "Assets/uploads/";

$user_id = $_SESSION['user_id'] ?? 0;


$rehomer_pets = [];
$application_status = [];
$adoption_history = [];
$user_info = [];
$groupedApplications = [];



if ($is_logged_in) {
    // Posted pets for rehoming
    $pets_result = mysqli_query($conn, "SELECT * FROM pet_details JOIN userprofile ON pet_details.user_id = userprofile.user_id WHERE pet_details.user_id = $user_id");
    while ($row = mysqli_fetch_assoc($pets_result)) {
        $rehomer_pets[] = $row;
    }

    //Adoption history
    $history_result = mysqli_query($conn, "
     SELECT 
    aa.application_id,
    aa.application_status,
    aa.submitted_date,
    p.*,
    u.user_name,
    u.user_email,
    u.user_address
FROM adoption_applications aa
JOIN pet_details p ON aa.pet_id = p.pet_id
JOIN userprofile u ON aa.user_id = u.user_id
       WHERE u.user_id = $user_id AND aa.application_status = 'Approved'");
    while ($row = mysqli_fetch_assoc($history_result)) {
        $adoption_history[] = $row;
    }
    
    //  status update
    $application_result = mysqli_query($conn, "
        SELECT 
    aa.application_id,
    aa.application_status,
    aa.submitted_date,
    p.pet_id,
    p.pet_name,
    p.photo_path,
    u.user_name AS applicant_name,
    u.user_email AS applicant_email,
    u.user_address AS applicant_address
FROM adoption_applications aa
JOIN pet_details p ON aa.pet_id = p.pet_id
JOIN userprofile u ON aa.user_id = u.user_id
WHERE p.adopted = 0
  AND p.user_id = $user_id
ORDER BY aa.submitted_date DESC
    ");
    while ($row = mysqli_fetch_assoc($application_result)) {
        $groupedApplications[$row['pet_id']]['pet_name'] = $row['pet_name'];
        $groupedApplications[$row['pet_id']]['photo_path'] = $row['photo_path'];
        $groupedApplications[$row['pet_id']]['applications'][] = $row;
    }
}

//Applications
$applied_result = mysqli_query($conn, "
SELECT 
aa.application_id,
aa.application_status,
aa.submitted_date,
p.*
FROM adoption_applications aa
JOIN pet_details p ON aa.pet_id = p.pet_id
WHERE aa.user_id = $user_id");
while ($row = mysqli_fetch_assoc($applied_result)) {
   $application_status[] = $row;
}

$favs_result = mysqli_query($conn,
    "SELECT pet_details.* FROM pet_details
     INNER JOIN favourites ON pet_details.pet_id = favourites.pet_id
     WHERE favourites.user_id = $user_id"
);
$favarray = array();
if (mysqli_num_rows($favs_result) > 0) {
	while ($x = mysqli_fetch_assoc($favs_result)) {
		array_push($favarray, $x);
	}
}
else {
    $error = " 😔 You donot have any Favourite Pets. ";

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
    <link rel="stylesheet" href="Assets/css/style.css">
    <link rel="stylesheet" href="Assets/css/navbar.css">
    <link rel="stylesheet" href="Assets/css/petlist.css">
    <link rel="stylesheet" href="Assets/css/userprofile.css">

    <style>
    .section {
        margin-bottom: 30px;
    }

    /* .container {
        min-height: 30vh;
        width: 100%;
        padding: 20px;
        margin: 50px auto;
    }

    .card {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
    } */
    .section-container {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    }

    .card.rehomer-card:hover {
        transform: none;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
        border: 2px solid #41613A;
        cursor: default;
    }

    .card h4 {
        margin: 0 0 10px 0;
    }

    h4 {
        color: #047857;
    }
    </style>

</head>

<body>
    <?php include 'navbar.php';?>


    <div class="user-section">
        <div class="topsec d-flex justify-content-between">
            <a href="index.php" class="btn btn-outline-secondary mb-4">
                ← Back to Home
            </a>
            <a href="logout.php" class="btn btn-secondary mb-4">
                Log Out <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>

        <div class="profile-header">
            <img src="Assets/uploads/<?= $userprofile ?? 'default-pet.jpg' ?>" alt="Profile" id="profile-pic" /><br />
            <div class="user-info">
                <h2><?php echo $userName; ?></h2>
                <p><strong>Email:</strong>&nbsp;<?php echo $userEmail; ?></p>
                <p><strong>Address:</strong>&nbsp;<?php echo $userAddress; ?></p>
                <a href="editprofile.php" class="edit-btn">Edit Profile</a>
                <a href="changePassword.php" class="password-btn">Change Password</a>
            </div>
        </div>

        <?php if (!empty($rehomer_pets)): ?>
        <div class="section">
            <h4>Your Posted Pets</h4>
            <div class="container section-container">
                <div class="row d-flex flex-wrap gap-3">
                    <?php foreach ($rehomer_pets as $pet): ?>

                    <div class="card rehomer-card px-0 ms-2">
                        <img src="<?= $imgdir.$pet['photo_path'] ?>" class="card-img-top" alt="<?= $pet['pet_name'] ?>"
                            onerror="this.src='<?= $imgdir.'default-pet.jpg'?>'">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars(string: $pet['pet_name']) ?></h5>
                            <p class="card-text">Species: <?= htmlspecialchars($pet['species']) ?><br>
                                Status: <?= $pet['adopted'] == 0 ? 'Available' : 'Adopted' ?>
                            </p>
                            <form action="delete_pet.php" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this pet?');">
                                <input type="hidden" name="pet_id" value="<?= $pet['pet_id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>

                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>


        <div class="section">
            <h4>Adoption Applications for Your Pets</h4>
            <div class="container section-container">
                <div class="row d-flex flex-wrap gap-3">
                    <?php if (empty($groupedApplications)): ?>
                    <p class="h5 text-center mt-5">No applications yet.</p>
                    <?php else: ?>
                    <?php foreach ($groupedApplications as $pet_id => $data): ?>
                    <div class="card rehomer-card px-0 ms-2">
                        <img src="<?= $imgdir.$data['photo_path']; ?>" class="card-img-top"
                            alt="<?= $data['pet_name'] ?>" onerror="this.src='<?= $imgdir.'default-pet.jpg'?>'">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($data['pet_name']) ?></h5>
                            <?php foreach ($data['applications'] as $app): ?>
                            <div class="border rounded p-3 mb-3">
                                <p><strong>Applicant:</strong> <?= htmlspecialchars($app['applicant_name']) ?>
                                </p>
                                <p><strong>Status:</strong> <?= $app['application_status'] ?></p>
                                <?php if ($app['application_status'] === 'Under Review'): ?>
                                <form action="update_application_status.php" method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
                                    <input type="hidden" name="pet_id" value="<?= $pet_id ?>">
                                    <button type="submit" name="status" value="Approved"
                                        class="btn btn-success">Approve</button>
                                    <button type="submit" name="status" value="Rejected"
                                        class="btn btn-danger">Reject</button>
                                </form>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($application_status)): ?>
        <div class="section">
            <h4>Application Status</h4>
            <div class="container section-container">
                <div class="row d-flex flex-wrap gap-3">
                    <?php foreach ($application_status as $app): ?>

                    <div class="card rehomer-card px-0 ms-2">
                        <img src="<?= $imgdir.$app['photo_path'] ?>" class="card-img-top" alt="<?= $app['pet_name'] ?>"
                            onerror="this.src='<?= $imgdir.'default-pet.jpg'?>'">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars(string: $app['pet_name']) ?></h5>
                            <p class="card-text"><strong>Species:</strong> <?= htmlspecialchars($app['species']) ?>
                                <br>
                                <strong>Status:</strong> <?= htmlspecialchars($app['application_status']) ?><br>
                                <strong>Submitted:</strong> <?= $app['submitted_date'] ?><br>

                            </p>


                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>



        <?php if (!empty($adoption_history)): ?>
        <div class="section">
            <h4>Adoption History</h4>
            <div class="container section-container">
                <div class="row d-flex flex-wrap gap-3">
                    <?php foreach ($adoption_history as $pet): ?>

                    <div class="card rehomer-card px-0 ms-2">
                        <img src="<?= $imgdir.$pet['photo_path'] ?>" class="card-img-top" alt="<?= $pet['pet_name'] ?>"
                            onerror="this.src='<?= $imgdir.'default-pet.jpg'?>'">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars(string: $pet['pet_name']) ?></h5>
                            <p class="card-text"><strong>Species:</strong> <?= htmlspecialchars($pet['species']) ?>
                                <br>
                                <strong>Status:</strong> Adopted <br>
                                <strong>Adopter Name:</strong> <?= htmlspecialchars($pet['user_name']) ?><br>
                                <strong>Adopter Address:</strong> <?= htmlspecialchars($pet['user_address']) ?><br>
                                <strong>Adopter Contact:</strong> <?= htmlspecialchars($pet['user_email']) ?><br>

                            </p>


                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>



        <section class="card-section">
            <h4>Saved/Favorite Pets</h4>
            <div class="container section-container">
                <div class="row">
                    <?php if (!empty($error)): ?>
                    <span class="h5 text-center mt-5"><?php echo $error; ?></span>
                    <?php endif; ?>
                    <div class="filtercards ">

                        <?php
            
                foreach($favarray as $y){

                    $id = $y['pet_id'];
                    $petName = $y['pet_name'];
                    $species = strtolower(trim($y['species']));
                    $age = $y['age'];
                    $gender = $y['gender'];
                    $imgprofile = $y['photo_path'];
                    $imgPath = (!empty($imgprofile) && file_exists($imgdir.$imgprofile))? $imgdir.$imgprofile: $imgdir.'default-pet.jpg';

                    echo '<div class="card fav-card rehomer-card p-0 ms-2" id="'.$id.'" data-name="'.$species.'"><img src="'.$imgPath.'" class="card-img-top" alt="'.$petName.'" onerror="this.src=\''.$imgdir.'default-pet.jpg\'"><div class="card-body"><h5 class="card-title">'.$petName.'</h5><p class="card-text">Species: '.$species.' <br>Age: '.$age.' years <br>Gender: '.$gender.' '.'</p></div></div> ';

                }
            
            ?>

                    </div>

                </div>
            </div>

        </section>
    </div>
    <script>
    const cards = document.querySelectorAll('.fav-card');

    cards.forEach(card => {

        card.addEventListener('click', () => {
            const pet = card.getAttribute('id');
            window.location.href = `petdetails.php?id=${pet}`;
        });
    });
    </script>
</body>

</html>