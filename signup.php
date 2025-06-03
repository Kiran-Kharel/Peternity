<?php
    error_reporting(E_ALL);
    $error = "";
    require_once("connect.php");
    if(isset($_POST['submit'])){

        $userName = $conn->real_escape_string(trim($_POST['username']));
        $userPwd = $conn->real_escape_string(trim($_POST['password']));
        $userRePwd = $conn->real_escape_string(trim($_POST['confirmpassword']));
        $userAddress = $conn->real_escape_string(trim($_POST['address']));
        $userEmail = $conn->real_escape_string(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));  
        $imgPath = null;

        if($userPwd !== $userRePwd){
            $error = "Failed to upload file";
        }
        $pwd = md5($userPwd);
        if (isset($_FILES['userProfile']) && $_FILES['userProfile']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $fileType = mime_content_type($_FILES['userProfile']['tmp_name']);
            
            if (!in_array($fileType, $allowedTypes)) {
            echo("Invalid file type.");        }

            $extension = pathinfo($_FILES['userProfile']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('user_', true) . '.' . $extension;
            $destination = 'Assets/uploads/' . $filename;
            
            if (!move_uploaded_file($_FILES['userProfile']['tmp_name'], $destination)) {
                echo("Failed to upload file");
            }
            $imgPath = $conn->real_escape_string($filename);
        }
        $query = "INSERT INTO userprofile (
            user_name, 
            user_password, 
            user_image, 
            user_address, 
            user_email	
        ) VALUES (
            '$userName',
            '$pwd',
            '$imgPath',
            '$userAddress',
            '$userEmail'       
        )";

        $insertion = mysqli_query($conn, $query);

        if (!$insertion) {
            echo("Failed to Create a Profile: " . mysqli_error( $conn));
        }else{
            header("Location: index.php");
            exit();    
        }
}
    
?>
<div class="container sign-up">
    <form method="POST" enctype="multipart/form-data">
        <h1>Sign Up</h1>
        <input type="text" name="username" placeholder="Name" /><br>
        <input type="password" name="password" placeholder="Password" /><br>
        <input type="password" name="confirmpassword" placeholder="RePassword" /><br>
        <p id="error"><?php echo $error; ?></p>
        <label for="userProfile">User Profile:</label><br>
        <input type="file" name="userProfile" placeholder="Profile Picture" accept="image/*" /><br>
        <input type="text" name="address" placeholder="Address" /><br>
        <input type="email" name="email" placeholder="Email" /><br>
        <button type="submit" name="submit" class="form-button">Sign Up</button><br>
        <span>---</span> <span>or</span> <span>---</span>
        <div class="social-icons">
            <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-instagram"></i></a>
        </div>
    </form>
</div>