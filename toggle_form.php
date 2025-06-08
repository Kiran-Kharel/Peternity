<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="Assets\images\petlogo-fav.png" type="image/x-icon">
    <!-- <link rel="stylesheet" type="text/css" href="Assets/CSS/form.css"> -->
    <link rel="stylesheet" href="Assets/css/style.css">
    <title>Form</title>
</head>

<body>
    <div class="form-container" id="form-container">
        <?php include'signup.php';?>


        <?php include'login.php';?>

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
</body>
<script src="form_toggle.js"></script>

</html>