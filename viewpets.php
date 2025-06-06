<?php 
require_once 'connect.php';

$outputarray = array();
$error = "";

if(isset($_GET['q']) && !empty($_GET['q'])) {
    $searchTerm = mysqli_real_escape_string($conn, trim($_GET['q']));
    $searchTerm = "%$searchTerm%";
    

    $query = "SELECT pet_details.*, userprofile.user_name, userprofile.user_email, userprofile.user_address
FROM pet_details
JOIN userprofile ON pet_details.user_id = userprofile.user_id
WHERE (
    pet_details.pet_name LIKE '%$searchTerm%' OR
    pet_details.species LIKE '%$searchTerm%' OR
    pet_details.age LIKE '%$searchTerm%' OR
    pet_details.gender LIKE '%$searchTerm%' OR
    userprofile.user_address LIKE '%$searchTerm%' OR
    userprofile.user_name LIKE '%$searchTerm%' OR
    userprofile.user_email LIKE '%$searchTerm%'
)
AND pet_details.adopted = 0
ORDER BY pet_details.pet_id DESC;
";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        while ($x = mysqli_fetch_assoc($result)) {
            array_push($outputarray, $x);
        }
    } else {
        $error = "<h1 class=\"my-5 text-center\"> 😭 No Pets Found. </h1>";
    }
}
else{
$fetchquery = "SELECT * FROM pet_details WHERE adopted = 0 ORDER BY pet_id DESC";
$fetchall = mysqli_query($conn, $fetchquery);

if (mysqli_num_rows($fetchall) > 0) {
	while ($x = mysqli_fetch_assoc($fetchall)) {
		array_push($outputarray, $x);
	}
}
else {
    $error = "<h1 class=\"my-5 text-center\"> 😭 No Pets Found. </h1>";

}
}
?>