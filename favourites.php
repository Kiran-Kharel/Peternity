<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connect.php';

$user_id = $_SESSION['user_id'];
$pet_id = $_POST['pet_id'];
$action = $_POST['action'];

if ($action === 'add') {
    mysqli_query($conn, "INSERT IGNORE INTO favourites (user_id, pet_id) VALUES ($user_id, $pet_id)");
} elseif ($action === 'remove') {
    mysqli_query($conn, "DELETE FROM favourites WHERE user_id = $user_id AND pet_id = $pet_id");
}

header("Location: petdetails.php?id=$pet_id");

?>