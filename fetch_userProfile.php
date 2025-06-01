<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['UserEmail'])) {
    error_reporting(E_ALL);
    require_once 'connect.php';
    $userEmail =  $_SESSION['UserEmail'];

    $fetchquery = "SELECT * FROM userprofile WHERE user_email = '$userEmail'";
    $fetch = mysqli_query($conn, $fetchquery);
    $data = mysqli_fetch_assoc($fetch);
    if(!empty($data)) {
        $userName = $data['user_name'];
        $userPwd =$data['user_password'];
        $userAddress = $data['user_address'];
        $userEmail = $data['user_email'];
        $userprofile = $data['user_image'];
    }
    else {
        echo"Error Finding User Details. ";

    }
}

    
?>