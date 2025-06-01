<?php 
require_once 'connect.php';
$pet_id = $_GET['id'];

$fetchquery = "SELECT * FROM pet_details WHERE pet_id = $pet_id";
$fetch = mysqli_query($conn, $fetchquery);
$data = mysqli_fetch_assoc($fetch);
if(!empty($data)) {
    $petName = $data['pet_name'];
    $species =$data['species'];
    $age = $data['age'];
    $gender = $data['gender'];
    $petBio = $data['bio'];
    $healthInfo = $data['health_info'];
    $ownerName = $data['owner_name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $location = $data['place'];
    $reason = $data['rehoming_reason'];
    $imgprofile = $data['photo_path'];
}
else {
    echo"Error Finding Pet Details. ";

}

?>