<?php 
require_once 'connect.php';

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

?>
<div class="featuresection">
    <h1 class="display-6 my-5 text-center fw-bold text-body-emphasis">Featured Pets</h1>
    <div class="container">
        <div class="row">
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
        <div class="my-5 text-center">
            <a href="petlist.php" class="d-inline-flex align-items-center btn btn-primary btn-lg px-4 rounded-pill"
                type="button">
                View More Pets &nbsp; <i class="fa-solid fa-angles-right"></i>
            </a>

        </div>
    </div>
</div>