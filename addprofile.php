<?php
require_once 'connect.php';
include 'check_user.php';
if($is_logged_in){
    if(isset($_POST['submit'])){

    $petName = $conn->real_escape_string(trim($_POST['petName']));
    $species = $conn->real_escape_string(trim($_POST['species']));
    $age = isset($_POST['age']) ? floatval($_POST['age']) : null;
    $gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : null;
    $petBio = $conn->real_escape_string(trim($_POST['petBio']));
    $healthinfo = $conn->real_escape_string(trim($_POST['healthinfo']));
    $ownerName = $conn->real_escape_string(trim($_POST['ownerName']));
    $email = $conn->real_escape_string(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $phone = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : null;
    $location = $conn->real_escape_string(trim($_POST['location']));
    $reason = $conn->real_escape_string(trim($_POST['reason']));
    $photoPath = null;

    if (isset($_FILES['petPhoto']) && $_FILES['petPhoto']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = mime_content_type($_FILES['petPhoto']['tmp_name']);
        
        if (!in_array($fileType, $allowedTypes)) {
           echo("Invalid file type.");
        }

        $extension = pathinfo($_FILES['petPhoto']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('pet_', true) . '.' . $extension;
        $destination = 'Assets/uploads/' . $filename;
        
        if (!move_uploaded_file($_FILES['petPhoto']['tmp_name'], $destination)) {
            echo("Failed to upload file");
        }
        
        $photoPath = $conn->real_escape_string($filename);
    }
   
    $query = "INSERT INTO pet_details (
        pet_name, 
        species, 
        age, 
        gender, 
        bio, 
        health_info, 
        rehoming_reason, 
        photo_path,
        adopted,
        created_at,
        user_id
    ) VALUES (
        '$petName',
        '$species',
        $age,
        '$gender',
        '$petBio',
        '$healthinfo',
        '$reason',
        '$photoPath',
        0,
        NOW(),
        $user_id
        )";

    $insertion = mysqli_query($conn, $query);


    if (!$insertion) {
        echo("Failed to Create a Profile: " . mysqli_error( $conn));
    }else{
        header("Location: petlist.php");
        exit();
    
    }


    // if (!$stmt->execute()) {
    //     throw new Exception("Execute failed: " . $stmt->error);
    // }
    // $newId = $stmt->insert_id;

    // $stmt->close();
    // $conn->close();

    }}else {
        header("Location: login.php");
        exit();
    }
?>