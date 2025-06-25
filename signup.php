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

       if(!empty($userName) && !empty($userPwd) && !empty($userRePwd) && !empty($userEmail)){
            
            $pwd = md5($userPwd);
        
        if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $fileType = mime_content_type($_FILES['user_image']['tmp_name']);
            
            if (!in_array($fileType, $allowedTypes)) {
            $error = "Invalid file type.";        }

            $extension = pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('user_', true) . '.' . $extension;
            $destination = 'Assets/uploads/' . $filename;
            
            if (!move_uploaded_file($_FILES['user_image']['tmp_name'], $destination)) {
                $error = "Failed to upload file";
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
            $error = "Failed to Create a Profile: " . mysqli_error( $conn);
        }else{
            header("Location: login.php");
            exit();    
        }
       }else{
        $error = "Fill in the required fields";
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
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css">

    <link rel="shortcut icon" href="Assets\images\petlogo-fav.png" type="image/x-icon">
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

    .toggle-icon {
        position: absolute;
        right: 15px;
        top: 72%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #555;
    }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="col-md-6 col-lg-5">
            <div class="card auth-card shadow p-4">
                <h3 class="text-center mb-4">Sign Up</h3>
                <form action="" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                    <span id="error" class="text-danger"><?php echo $error; ?></span>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="user_name" pattern="[A-Za-z ]{3,50}" required>
                        <div class="invalid-feedback" id="usernameError"></div>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="user_email"
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                        <div class="invalid-feedback" id="emailError"></div>

                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="user_password" id="password" required>
                        <div class="invalid-feedback" id="passwordError"></div>
                        <i class="fa-solid fa-eye toggle-icon" onclick="togglePwd('password', this)"></i>

                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="user_repassword" id="confirm_password"
                            required>
                        <div class="invalid-feedback" id="confirmPasswordError"></div>
                        <i class="fa-solid fa-eye toggle-icon" onclick="togglePwd('confirm_password', this)"></i>

                        <!-- <div class="invalid-feedback" id="password-mismatch">Passwords do not match.</div> -->
                        <!-- <span id="error" class="text-danger"><?php echo $error; ?></span> -->
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="user_address">
                        <div class="invalid-feedback" id="addressError"></div>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" pattern="[0-9]{10}" name="user_phone">
                        <div class="invalid-feedback" id="phoneError"></div>

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
    function togglePwd(id, icon) {
        const input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    (() => {
        'use strict';

        const form = document.querySelector('.needs-validation');
        const usernameInput = document.querySelector('input[name="user_name"]');
        const usernameError = document.getElementById('usernameError');

        const addressInput = document.querySelector('input[name="user_address"]');
        const addressError = document.getElementById('addressError');

        const password = document.getElementById('password');
        const passwordError = document.getElementById('passwordError');

        const confirmPassword = document.getElementById('confirm_password');
        const confirmPasswordError = document.getElementById('confirmPasswordError');

        const emailInput = document.querySelector('input[name="user_email"]');
        const emailError = document.getElementById('emailError');

        const phoneInput = document.querySelector('input[name="user_phone"]');
        const phoneError = document.getElementById('phoneError');

        function isValidPhone(phone) {
            const phonePattern = /^[9][8-9][0-9]{8}$/;
            return phonePattern.test(phone);
        }

        function isValidEmail(email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }

        function hasSpecialChar(str) {
            return /[!@#$%^&*(),.?":{}|<>]/.test(str);
        }

        form.addEventListener('submit', (event) => {
            event.preventDefault(); // Always stop form submit first!
            let valid = true;

            // Clear all errors:
            usernameError.textContent = "";
            addressError.textContent = "";
            emailError.textContent = "";
            passwordError.textContent = "";
            confirmPasswordError.textContent = "";
            phoneError.textContent = "";

            usernameInput.classList.remove('is-invalid');
            addressInput.classList.remove('is-invalid');
            emailInput.classList.remove('is-invalid');
            password.classList.remove('is-invalid');
            confirmPassword.classList.remove('is-invalid');
            phoneInput.classList.remove('is-invalid');

            // --- Username empty check ---
            if (usernameInput.value.trim() === "") {
                usernameError.textContent = "❌ Username is required.";
                usernameInput.classList.add('is-invalid');
                valid = false;
            }

            // --- Address empty check ---
            if (addressInput.value.trim() === "") {
                addressError.textContent = "❌ Address is required.";
                addressInput.classList.add('is-invalid');
                valid = false;
            }
            // Validate email:
            if (emailInput.value.trim() === "") {
                emailError.textContent = "❌ Email is required.";
                emailInput.classList.add('is-invalid');
                valid = false;
            } else if (!isValidEmail(emailInput.value.trim())) {
                emailError.textContent = "❌ Invalid email format.";
                emailInput.classList.add('is-invalid');
                valid = false;
            }


            // Validate phone:
            if (phoneInput.value.trim() === "") {
                phoneError.textContent = "❌ Phone number is required.";
                phoneInput.classList.add('is-invalid');
                valid = false;
            } else if (!isValidPhone(phoneInput.value.trim())) {
                phoneError.textContent = "❌ Enter valid 10-digit Nepali phone number.";
                phoneInput.classList.add('is-invalid');
                valid = false;
            }

            // Validate password:
            if (password.value.length < 8) {
                passwordError.textContent = "❌ Password must be at least 8 characters long.";
                password.classList.add('is-invalid');
                valid = false;
            } else if (!hasSpecialChar(password.value)) {
                passwordError.textContent = "❌ Password must contain at least one special character.";
                password.classList.add('is-invalid');
                valid = false;
            }

            // Validate confirm password:
            if (password.value !== confirmPassword.value) {
                confirmPasswordError.textContent = "❌ Passwords do not match.";
                confirmPassword.classList.add('is-invalid');
                valid = false;
            }

            // Finally, submit if valid:
            if (valid) {
                form.submit(); // Manually submit if all valid
            }
        });
    })();
    </script>
</body>

</html>