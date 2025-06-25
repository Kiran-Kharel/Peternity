<link rel="shortcut icon" href="Assets\images\petlogo-fav.png" type="image/x-icon">
<?php
    require 'connect.php';
    require_once 'check_user.php'; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($new !== $confirm) {
            echo "Passwords do not match.";
            exit;
            
        }

        $hashed = md5($new);
        $stmt = $conn->prepare("UPDATE userprofile SET user_password = ? WHERE user_email = ?");
        $updated = $stmt->execute([$hashed, $email]);

        if ($updated) {
            echo "<script>alert('Password updated successfully!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Failed to update password.');</script>";
        }

    }
?>
