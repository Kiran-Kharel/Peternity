<?php
    error_reporting(E_ALL);
    $error = "";
    require_once("connect.php");
    if(isset($_POST['submit'])){

        $userName = $conn->real_escape_string(trim($_POST['user_name']));
        $userPwd = $conn->real_escape_string(trim($_POST['user_password']));
        $userRePwd = $conn->real_escape_string(trim($_POST['user_repassword']));
        $userAddress = $conn->real_escape_string(trim($_POST['user_address']));
        $userEmail = $conn->real_escape_string(filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL));  
        $userPhone = $conn->real_escape_string(trim($_POST['user_phone']));
        $imgPath = null;

        if($userPwd !== $userRePwd){
            $error = "Password does not match";
        }else{
            $pwd = md5($userPwd);
        
        if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $fileType = mime_content_type($_FILES['user_image']['tmp_name']);
            
            if (!in_array($fileType, $allowedTypes)) {
            echo("Invalid file type.");        }

            $extension = pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('user_', true) . '.' . $extension;
            $destination = 'Assets/uploads/' . $filename;
            
            if (!move_uploaded_file($_FILES['user_image']['tmp_name'], $destination)) {
                echo("Failed to upload file");
            }
            $imgPath = $conn->real_escape_string($filename);
        }
        $query = "INSERT INTO userprofile (
            user_name, 
            user_password, 
            user_image, 
            user_address, 
            user_email,	
            user_phone
        ) VALUES (
            '$userName',
            '$pwd',
            '$imgPath',
            '$userAddress',
            '$userEmail',
            '$userPhone'       
        )";

        $insertion = mysqli_query($conn, $query);

        if (!$insertion) {
            echo("Failed to Create a Profile: " . mysqli_error( $conn));
        }else{
            header("Location: login.php");
            exit();    
        }
    }
}
    
?>
<!-- <div class="container sign-up">
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
</div> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="navbar.css" rel="stylesheet">
    <style>
    body {
        background-color: #DFFBF3;
    }

    .auth-card {
        background: #fff;
        border: 2px solid #213F12;
        border-radius: 12px;
    }

    .auth-card h3 {
        color: #213F12;
    }

    .btn-auth {
        background-color: #213F12;
        color: white;
    }

    .btn-auth:hover {
        background-color: #1b3510;
    }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="col-md-6 col-lg-5">
            <div class="card auth-card shadow p-4">
                <h3 class="text-center mb-4">Sign Up</h3>
                <form action="" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="user_name" pattern="[A-Za-z ]{3,50}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="user_email"
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="user_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="user_repassword" required>
                    </div>
                    <span id="error" class="text-danger"><?php echo $error; ?></span>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="user_address">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" pattern="[0-9]{10}" name="user_phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" class="form-control" name="user_image" accept="image/*">
                    </div>
                    <button type="submit" name="submit" class="btn btn-success w-100">Sign Up</button>
                    <div class="text-center mt-3">
                        <a href="login.php">Already have an account? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
    </script>
</body>

</html>