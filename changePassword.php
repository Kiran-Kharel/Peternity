<?php
    require 'connect.php';
    require_once 'check_user.php';     
    include 'fetch_userProfile.php';
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $email = $_SESSION['reset_email'] ?? '';
    $userExists = false;

    if (!empty($email)) {
        $stmt = $conn->prepare("SELECT * FROM userprofile WHERE user_email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $userExists = true;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {        
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        
        if ($new !== $confirm) {
            echo "<script>alert('❌ Passwords do not match.'); window.history.back();</script>";
            exit;
        }

        // Hashing and updating
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE userprofile SET user_password = ? WHERE user_email = ?");
        $updated = $stmt->execute([$hashed, $email]);

        if ($updated) {
            unset($_SESSION['reset_email']);
            echo "<script>alert('✅ Password updated successfully!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('❌ Failed to update password.');</script>";
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
        <form method="POST" action="update_pwd.php" onsubmit="return validatePassword();">
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

            <span id="errorSpan" style="color: red; font-size: 14px;"></span>

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
            function validatePassword() {
                const password = document.getElementById("new_pwd").value;
                const confirm = document.getElementById("confirm_pwd").value;
                const errorSpan = document.getElementById("errorSpan");
                const specialCharPattern = /[!@#$%^&*(),.?":{}|<>]/;

                if (password.length < 8) {
                    errorSpan.textContent = "❌ Password must be at least 8 characters long.";
                    return false;
                }

                if (!specialCharPattern.test(password)) {
                    errorSpan.textContent = "❌ Password must contain at least one special character.";
                    return false;
                }

                if (password !== confirm) {
                    errorSpan.textContent = "❌ Passwords do not match.";
                    return false;
                }

                return true;
            }
    </script>
</body>
</html>
