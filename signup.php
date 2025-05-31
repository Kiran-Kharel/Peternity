<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/signup.css">
    <link rel="stylesheet" href="Assets/css/style.css">
    <title>Sign Up</title>
</head>
<body>
    <div class="form-container" id="form-container">
        <div class="container sign-up">
            <form action="" >
                <h1>Sign Up</h1>                
                    <input type="text" name="username" placeholder= "Name"/><br>
                    <input type="password" name="password" placeholder= "Password"/><br>
                    <input type="password" name="confirmpassword" placeholder= "RePassword"/><br>
                    <label for="userProfile">User Profile:</label><br>
                    <input type="file" name="userProfile" placeholder= "Profile Picture"/><br>
                    <input type="text" name="address" placeholder= "Address"/><br>
                    <input type="email" name="email" placeholder= "Email"/><br>
                    <button class="form-button">Sign Up</button><br>
                    <span>---</span> <span>or</span> <span>---</span>
                <div class="social-icons"> 
                    <a href="#" class="icon"><i class="fab fa-google"></i></a>
                    <a href="#" class="icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fab fa-instagram"></i></a>
                </div>
            </form>
        </div>
        <div class="container sign-in">
            <form action="">
                <div class="social-icons"> 
                    <a href="#" class="icon"><i class="fab fa-google"></i></a>
                    <a href="#" class="icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fab fa-instagram"></i></a>
                </div>
                <span>or use your email & password</span><br>
                <input type="text" name="username" placeholder= "Name"/><br>
                <input type="password" name="password" placeholder= "Password"/><br>
                <a href="#">Forget Your Password?</a><br>
                <button class="form-button">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <!-- <img src="Assets/images/welcome.jpg" alt="" width=330 height=300/> -->
                    <h1>Meet your new furry friend</h1>
                    <p>Register with your personal details to discover pets which are waiting for you!</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
                <div class="toggle-panel toggle-left">
                    <!-- <img src="Assets/images/signin-dog.jpg" alt="" width=330 height= 300/> -->
                    <h1>Support Sustainable Pet Adoption</h1>
                    <p>Adopt a pet, Transform a Life</p>
                    <button class="hidden" id="register">Sign In</button>
                </div>
            </div>  
        </div>
    </div>


    <script src="script.js"></script> 
    
</body>
</html>


    
