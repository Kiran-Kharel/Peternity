<?php
    require_once 'connect.php';
    require_once 'check_user.php';   
    include 'check_session.php'; 
    include 'fetch_userProfile.php';
    if(isset($_POST['submit'])){
        $userPwd = $conn->real_escape_string(trim($_POST['new_password']));
        $userRePwd = $conn->real_escape_string(trim($_POST['confirm_password']));
    }
    if($userPwd !== $userRePwd){
            alert("❌ New password and confirmation do not match.");
    }
    $pwd = md5($userPwd);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link rel="stylesheet" href="Assets/css/style.css">
        <title>Change Password</title>
    </head>
    <body>
       <div class="container edit_password">
        <form id="changepwd_form" action="" method="POST">
            <h1>Change Password</h1>
            <input type="hidden" name="email" placeholder="Email" value="<?php echo $userEmail?>"/><br>
            <input type="password" name="new_password" placeholder="New Password"  required><br>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required><br>
            <button type="submit" name="change-pwd" class="form-button">Change Password</button>
        </form>

    <p id="error1"><?php echo $error; ?></p>
</div> 
    </body>
</html>