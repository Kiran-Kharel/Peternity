<?php 
require_once 'connect.php';
require_once 'check_user.php';   
include 'check_session.php';            
$fetchquery = "SELECT * FROM pet_details ORDER BY pet_id DESC LIMIT 3";
$fetchall = mysqli_query($conn, $fetchquery);

$outputarray = array();
if (mysqli_num_rows($fetchall) > 0) {
	while ($x = mysqli_fetch_assoc($fetchall)) {
		array_push($outputarray, $x);
	}
}
else {
    echo" 😭 No Pets Found. ";

}
$imgdir = "Assets/uploads/";

$user_id = $_SESSION['user_id'] ?? 0;

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
    echo" 😔 You donot have any Favourite Pets. ";

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peternity</title>
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
    <link rel="stylesheet" href="Assets/css/petlist.css">
    <link rel="stylesheet" href="Assets/css/userprofile.css">



</head>

<body>
    <?php include'navbar.php';?>

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
            <img src="Assets/images/default-pet.jpg" alt="Profile" id="profile-pic" /><br />
            <div class="user-info">
                <h2><?php echo $userName; ?></h2>
                <p><strong>Email:</strong>&nbsp;<?php echo $userEmail; ?></p>
                <p><strong>Address:</strong>&nbsp;<?php echo $userAddress; ?></p>
                <a href="#" class="edit-btn">Edit Profile</a>
                <a href="#" class="password-btn">Change Password</a>
            </div>
        </div>
        <section class="card-section">
            <h3>Adoption History</h3>
            <div class="parts">
                <?php            
                foreach($outputarray as $x){

                    $id = $x['pet_id'];
                    $petName = $x['pet_name'];
                    $species = strtolower(trim($x['species']));
                    $age = $x['age'];
                    $gender = $x['gender'];
                    $imgprofile = $x['photo_path'];
                    $imgPath = (!empty($imgprofile) && file_exists($imgdir.$imgprofile))? $imgdir.$imgprofile: $imgdir.'default-pet.jpg';

                    echo '<div class="card px-0" id="'.$id.'" data-name="'.$species.'"><img src="'.$imgPath.'" class="card-img-top" alt="'.$petName.'" onerror="this.src=\''.$imgdir.'default-pet.jpg\'"><div class="card-body"><h5 class="card-title">'.$petName.'</h5><p class="card-text">Species: '.$species.' <br>Age: '.$age.' years <br>Gender: '.$gender.' '.'</p></div></div> ';
                }        
            ?>
            </div>
        </section>
        <section class="card-section">
            <h3>Application Status</h3>
            <div class="parts">
                <img src="Assets/images/cats-8105667_1280.jpg" alt="Cat" />
                <div class="card-info">
                    <h4>Name: Kitty</h4>
                    <p>Species: Cat</p>
                    <p>Status: Under Review</p>
                    <p>Submitted: 2025-05-20</p>
                </div>
            </div>
        </section>
        <section class="card-section">
            <h3>Saved / Favorite Pets</h3>
            <div class="favorites-grid">
                <div class="filtercards mt-5">
                    <?php
            
                foreach($favarray as $y){

                    $id = $y['pet_id'];
                    $petName = $y['pet_name'];
                    $species = strtolower(trim($y['species']));
                    $age = $y['age'];
                    $gender = $y['gender'];
                    $imgprofile = $y['photo_path'];
                    $imgPath = (!empty($imgprofile) && file_exists($imgdir.$imgprofile))? $imgdir.$imgprofile: $imgdir.'default-pet.jpg';

                    echo '<div class="card" id="'.$id.'" data-name="'.$species.'"><img src="'.$imgPath.'" class="card-img-top" alt="'.$petName.'" onerror="this.src=\''.$imgdir.'default-pet.jpg\'"><div class="card-body"><h5 class="card-title">'.$petName.'</h5><p class="card-text">Species: '.$species.' <br>Age: '.$age.' years <br>Gender: '.$gender.' '.'</p></div></div> ';

                }
            
            ?>

                </div>

            </div>
        </section>
    </div>