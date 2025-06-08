<?php 
    require_once 'connect.php';
    require_once 'check_user.php';   
    include 'check_session.php'; 
    include 'fetch_userProfile.php'; //databse existing data
    $path = "Assets/uploads/";
    $error = "";
    if(isset($_POST['submit']))
	{        
      	$userid = $_POST['user_id'];	
		$name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
		$upload_img = "";
		$old_userprofile = $_POST['old_userprofile'];
       
		if(!empty($_FILES['userProfile']['name']))
        // ($img_path,$imgname,$temp_imgname);
		{
			// checking if img upload is done with out error
			if($_FILES['userProfile']['error'] == UPLOAD_ERR_OK)
			{
				$img = $_FILES['userProfile']['name'];
				$temp_imgname = $_FILES['userProfile']['tmp_name'];

				$temp = explode(".", $img);
                $ext = end($temp);//explode and takes
                $img_name = rand(0,68748377279282).rand(0,3000).".".$ext;
                echo $img_name;
                $target_file = $path.$img_name;
                
                if(file_exists($target_file))//Check if the file exist or not
                {
                    echo "This file exist already";
                }
                else
                {
                    if(move_uploaded_file($temp_imgname, $target_file))
                    {
                       echo "Error occured uploading the file"; 
                    }
                }

				// //deleting old banner image
				// unlink($old_userprofile);
			}
			else
			{
				echo "Error:".$_FILES['userProfile']['error'];
			}
		}
		else
		{
			$img_name = $old_userprofile; //if it is empty then the same old will display
		}	
				
		$update = "update userprofile set user_name = '$name',
		user_image = '$img_name' ,
		user_address = '$address',
		user_email = '$email',
		user_phone = '$phone'                                        
                     where user_id = $userid";
		
		if($conn->query($update))
		{
			header("Location:userprofile.php");
		}
		else 
		{
			$error = "Error while updating record";
		} 	
		
	}		
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
    <link rel="stylesheet" href="Assets/css/editprofile.css">
    <link rel="shortcut icon" href="Assets\images\petlogo-fav.png" type="image/x-icon">
    <title>Edit User Profile</title>
</head>

<body>
    <div class="edit-profile-wrapper">
        <div class="slideshow">
            <img src="Assets/images/welcome.jpg" class="slide active">
            <img src="Assets/images/05_Rabbit_S_Nemo_2262.jpg.webp" class="slide">
            <img src="Assets/images/cats-8105667_1280.jpg" class="slide">
        </div>
        <div class="edit-form">
            <form method="POST" enctype="multipart/form-data">
                <h1>Edit Profile</h1>
                <span id="error" class="text-danger"><?php echo $error; ?></span>

                <input type="hidden" name="user_id" value="<?php echo $userId;?>" />
                <input type="hidden" name="old_userprofile" value="<?php echo $userImage;?>" />
                <!-- <label for="userProfile">User Profile:</label> -->
                <img id="pp" src="<?= $path.$userImage;?>" alt="Profile Pic" width=200px height=200px
                    onerror="this.src='Assets/images/default-pet.jpg'" />
                <!-- <label for="userProfile">Change Profile:</label> -->
                <input type="text" name="name" placeholder="Name" value="<?php echo $userName?>" />
                <input type="file" name="userProfile" placeholder="Profile Picture" accept="image/*" />
                <input type="text" name="address" placeholder="Address" value="<?php echo $userAddress?>" />
                <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Email"
                    value="<?php echo $userEmail?>" />
                <input type="tel" name="phone" pattern="[0-9]{10}" placeholder="Phone Number"
                    value="<?php echo $userPhone?>" />
                <button type="submit" name="submit" class="form-button">Save Changes</button>
            </form>
        </div>
    </div>
</body>
<script>
document.querySelector('input[name="userProfile"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('pp').src = URL.createObjectURL(
            file
        ); //creates a temporary local URL pointing to the selected image file so it can be previewed in the browser.
    }
});

const slides = document.querySelectorAll('.slide');
let index = 0;

function showSlide(i) {
    slides.forEach((slide, idx) => {
        slide.classList.remove('active');
        if (idx === i) slide.classList.add('active');
    });
}
setInterval(() => {
    index = (index + 1) % slides.length;
    showSlide(index);
}, 3000);
</script>

</html>