<?php
    $token = $_GET['token'] ?? '';
?>

<form id="resetPwd-form" action="update_pwd.php" method="POST">
    <h3>Reset Your Password</h3>
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <input type="password" name="new_password" placeholder="New Password" required><br><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
    <button type="submit">Reset Password</button>
</form>
