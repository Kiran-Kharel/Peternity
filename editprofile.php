<?php 
    require_once 'connect.php';
    require_once 'check_user.php';   
    include 'check_session.php'; 
    include 'fetch_userProfile.php';  
?>
<div class="container sign-up">
            <form method="POST" enctype="multipart/form-data">
                <h1>Sign Up</h1>                
                    <input type="text" name="username" placeholder= "Name"/><br>
                    <input type="password" name="password" placeholder= "Password"/><br>
                    <input type="password" name="confirmpassword" placeholder= "RePassword"/><br>
                    <p id="error" ><?php echo $error; ?></p>
                    <label for="userProfile">User Profile:</label><br>
                    <input type="file" name="userProfile" placeholder= "Profile Picture" accept="image/*"/><br>
                    <input type="text" name="address" placeholder= "Address"/><br>
                    <input type="email" name="email" placeholder= "Email"/><br>
                    <button type="submit" name="submit" class="form-button">Sign Up</button><br>
                <span>---</span> <span>or</span> <span>---</span>
                <div class="social-icons"> 
                    <a href="#" class="icon"><i class="fab fa-google"></i></a>
                    <a href="#" class="icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fab fa-instagram"></i></a>
                </div>
            </form>
</div>