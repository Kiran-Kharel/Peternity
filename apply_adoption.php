<?php
include 'check_user.php';
include 'connect.php';

if ($is_logged_in && isset($_GET['i'])) {
    $pet_id = $_GET['i'];
    $user_id = $_SESSION['user_id'];

    $check = mysqli_query($conn, "SELECT * FROM adoption_applications WHERE user_id = $user_id AND pet_id = $pet_id");
    if (mysqli_num_rows($check) === 0) {
        $insert = mysqli_query($conn, "INSERT INTO adoption_applications (user_id, pet_id, application_status) VALUES ($user_id, $pet_id, 'Under Review')");
        $success = true;
    } else {
        $already_applied = true;
    }
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Application Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <?php if (!empty($success)): ?>
        <div class="alert alert-success">🤗 Application submitted successfully! 🎉</div>
        <?php elseif (!empty($already_applied)): ?>
        <div class="alert alert-warning">🤔 You have already applied for this pet.</div>
        <?php endif; ?>
        <a href="userprofile.php" class="btn btn-primary">Back to Profile</a>
    </div>
</body>

</html>