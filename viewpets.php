<?php 
require_once 'connect.php';

$outputarray = array();


if(isset($_GET['q']) && !empty($_GET['q'])) {
    $searchTerm = mysqli_real_escape_string($conn, trim($_GET['q']));
    $searchTerm = "%$searchTerm%";
    
    $query = "SELECT * FROM pet_details
              WHERE pet_name LIKE '$searchTerm'
                 OR species LIKE '$searchTerm'
                 OR age LIKE '$searchTerm'
                 OR gender LIKE '$searchTerm'
              ORDER BY id DESC
            ";
    
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        while ($x = mysqli_fetch_assoc($result)) {
            array_push($outputarray, $x);
        }
    } else {
        echo "<h1 class=\"my-5 text-center\"> 😭 No Pets Found. </h1>";
    }
}
else{
$fetchquery = "SELECT * FROM pet_details ORDER BY id DESC";
$fetchall = mysqli_query($conn, $fetchquery);

if (mysqli_num_rows($fetchall) > 0) {
	while ($x = mysqli_fetch_assoc($fetchall)) {
		array_push($outputarray, $x);
	}
}
else {
    echo "<h1 class=\"my-5 text-center\"> 😭 No Pets Found. </h1>";

}
}
?>