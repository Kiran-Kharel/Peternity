<?php
include 'check_user.php';
include 'connect.php';
include 'check_session.php';

if (isset($_POST['delete']) && isset($_POST['pet_id'])) {
   
        $pet_id = $_POST['pet_id'];
        $user_id = $_SESSION['user_id'];

        $check_query = "SELECT * FROM pet_details WHERE pet_id = $pet_id AND user_id = $user_id";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) === 1) {
            $delete_query = "DELETE FROM pet_details WHERE pet_id = $pet_id";
            if (mysqli_query($conn, $delete_query)) {
                header("Location: userprofile.php");
                exit();
            } else {
                die("Error deleting pet: " . mysqli_error($conn));
            }
        } else {
            die("Pet not found or access denied.");
        }
   
} else {
    header("Location: userprofile.php");
    exit();
}
?>