<?php
session_start();
include 'connect.php';

$pet_id = $_POST['pet_id'];
$adopted = $_POST['adopted'];

$sql = "UPDATE pet_details SET adopted = $adopted WHERE pet_id = $pet_id";
mysqli_query($conn, $sql);

header("Location: userprofile.php");