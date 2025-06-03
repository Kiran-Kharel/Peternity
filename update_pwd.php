<?php
    require 'connect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['token'];
        $newPass = $_POST['new_password'];
        $confirmPass = $_POST['confirm_password'];

        if ($newPass !== $confirmPass) {
            echo "Passwords do not match.";
            exit;
        }

        $stmt = $conn->prepare("SELECT user_id, reset_expiry FROM userprofile WHERE reset_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if (!$user || strtotime($user['reset_expiry']) < time()) {
            echo "Invalid or expired token.";
            exit;
        }

        $hashedPassword = md5($newPass);
        $stmt = $conn->prepare("UPDATE users SET password = '$hashedPassword', reset_token = NULL, reset_expiry = NULL WHERE u_id = ?");
        $stmt->execute([$hashedPassword, $user['id']]);

        echo "Password has been reset successfully!";
    }
?>
