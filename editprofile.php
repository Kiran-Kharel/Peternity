<?php 
    require_once 'connect.php';
    require_once 'check_user.php';   
    include 'check_session.php'; 
    include 'fetch_userProfile.php'; //databse existing data
    $path = "Assets/uploads/";
    // $outputarray = array();
	// 	$select = "select * from  userprofile";
	// 	$result = mysqli_query($con, $select);
	// 	if(mysqli_num_rows($result)>0){
	// 			while($data = mysqli_fetch_assoc($result))
	// 	{
	// 		array_push($outputarray, $data);
	// 	}
	// 	   echo $outputarray;
	// 	}		
	// 	else
	// 	{
	// 		echo "No record found";
	// 	}
    
    if(isset($_POST['submit']))
	{
        
      	$userid = $_POST['user_id'];	
		$name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
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

				//deleting old banner image
				unlink($old_userprofile);
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
                                          user_address = '$address',
                                          user_email = '$email',
                                          user_image = '$img_name'                                          
                     where user_id = $userid";
		if($update)
		{
			echo "Record updated successfully</br>";
			header("Location:userprofile.php");

		}else
		{
			echo "Error while updating record </br>";
		}
		if($conn->query($update))
		{
			return true;
		}
		else 
		{
			return false;
		} 	
		
	}		
?>
<div class="container edit-form">
            <form method="POST" enctype="multipart/form-data">
                <h1>Edit Profile</h1>     
                    <input type="hidden" name="user_id" value="<?php echo $userId;?>"/> 
                    <input type="hidden" name="old_userprofile" value="<?php echo $userprofile;?>"/>     
                    <input type="text" name="name" placeholder= "Name" value="<?php echo $userName?>"/><br>
                    <label for="userProfile">User Profile:</label><br>
                    <img id="pp" src="Assets/uploads/<?= $userprofile;?>" alt="Profile Pic" width=80px height=80px></br></br>
                    <label for="userProfile">Change Profile:</label><br>
                    <input type="file" name="userProfile" placeholder= "Profile Picture" accept="image/*"/><br>
                    <input type="text" name="address" placeholder= "Address" value="<?php echo $userAddress?>"/><br>
                    <input type="email" name="email" placeholder= "Email" value="<?php echo $userEmail?>"/><br>
                    <button type="submit" name="submit" class="form-button">Save Changes</button><br>
            </form>
</div>