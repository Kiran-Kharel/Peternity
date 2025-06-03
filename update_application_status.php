<?php

include 'check_user.php';
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_id = $_POST['application_id'];
    $pet_id = $_POST['pet_id'];
    $status = $_POST['status'];
    
    mysqli_query($conn, "UPDATE adoption_applications SET application_status = '$status' WHERE application_id = $application_id");

    if ($status === 'Approved') {
        mysqli_query($conn, "UPDATE pet_details SET adopted = 1 WHERE pet_id = $pet_id");
        mysqli_query($conn, "UPDATE adoption_applications SET application_status = 'Rejected' WHERE pet_id = $pet_id AND application_id != $application_id");
    }

    header("Location: userprofile.php");
    exit();
}
?>