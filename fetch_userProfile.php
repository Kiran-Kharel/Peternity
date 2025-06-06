<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    error_reporting(E_ALL);
    require_once 'connect.php';
    $userId =  $_SESSION['user_id'];
    $fetchquery = "SELECT * FROM userprofile WHERE user_id = '$userId'";
    $fetch = mysqli_query($conn, $fetchquery);
    $data = mysqli_fetch_assoc($fetch);
    if(!empty($data)) {
        $userName = $data['user_name'];
        $userPwd =$data['user_password'];
        $userAddress = $data['user_address'];
        $userEmail = $data['user_email'];
        $userImage = $data['user_image'];
        $userPhone = $data['user_phone'];
        $userId = $data['user_id'];
    }
    else {
        echo"Error Finding User Details. ";

    }
    
}

    
?>