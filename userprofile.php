<link rel="stylesheet" href="Assets/css/userprofile.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<?php 
require_once 'connect.php';

$fetchquery = "SELECT * FROM pet_details ORDER BY id DESC LIMIT 3";
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

?>
<div class="user-section">
    <a href="index.php" class="btn btn-outline-secondary mb-4">
        ← Back to Home
    </a>
    <div class="profile-header">
        <img src="Assets/images/default-pet.jpg" alt="Profile" id="profile-pic"/><br/>
        <div class="user-info">
            <h2>Kiran Kharel</h2>
            <p>Email:</p>
            <p>Address:</p>
            <a href="#" class="edit-btn">Edit Profile</a>
            <a href="#" class="password-btn">Change Password</a>
        </div>
    </div>
    <section class="card-section">
        <h3>Adoption History</h3>
        <div class="parts">
            <?php            
                foreach($outputarray as $x){

                    $id = $x['id'];
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
            <div class="fav-card">
            <img src="Assets\images\05_Rabbit_S_Nemo_2262.jpg.webp" alt="Rabbit" />
            <h4>Snowball</h4>
            <a href="#">Apply Now</a>
            </div>
            <div class="fav-card">
            <img src="Assets/images/hamster-5115246_1280.jpg" alt="DogHamster" />
            <h4>Max</h4>
            <a href="#">Apply Now</a>
            </div>
        </div>
    </section>
</div>