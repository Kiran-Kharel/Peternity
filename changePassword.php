<?php
    require 'connect.php';
    require_once 'check_user.php';     
    include 'fetch_userProfile.php';
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $email = $_POST['email'] ?? '';
    $userExists = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($email)) {
        $stmt = $conn->prepare("SELECT * FROM userprofile WHERE user_email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $userExists = true;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css">
    <link rel="stylesheet" href="Assets/css/changepwd.css">
    <link rel="shortcut icon" href="Assets\images\petlogo-fav.png" type="image/x-icon">
    <title>Reset Password</title>
   
</head>
<body>
    <?php if ($userExists): ?>
        <form method="POST" action="update_pwd.php">
            <h3>Reset Password</h3>
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <div class="password-field">
                <input type="password" id="new_pwd" name="new_password" placeholder="New Password" required>
                <i class="fa-solid fa-eye toggle-icon" onclick="togglePwd('new_pwd', this)"></i>
            </div>
            <div class="password-field">
                <input type="password" id="confirm_pwd" name="confirm_password" placeholder="Confirm Password" required>
                <i class="fa-solid fa-eye toggle-icon" onclick="togglePwd('confirm_pwd', this)"></i>
            </div>
                <button type="submit">Reset</button>
        </form>
        <?php else: ?>
            <form>
                <h3>Email Not Found</h3>
                <p>Please go back and try again.</p>
                <a href="emailform.php" class="back-btn">
                ← Back
                </a>
            </form>
        <?php endif; ?>
    
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
    </script>
</body>
</html>
