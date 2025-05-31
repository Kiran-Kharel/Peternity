<?php
    session_start();
    error_reporting(E_ALL);
    require_once("connect.php");
    $error = "";
    if(isset($_POST['login']))
    {
        //sql injection prevention
        $userEmail = $conn->real_escape_string(trim($_POST['useremail']));
        $userPwd = $conn->real_escape_string(trim($_POST['password']));
        $password = md5($userPwd);
        echo $password;
        $select = "Select * from userprofile where user_email= '$userEmail'";
		$result = $conn->query($select);
		if( mysqli_num_rows($result)>0)
		{
			/*while($data = mysqli_fetch_assoc($result))
			{
				$Final[] = $data;
			}
			return $Final;*/
			$data = $result ->fetch_assoc();
        }
		else
		{
			echo "No record found";
		}
        echo $data['user_password'];  
           /*echo"<pre>";
           print_r($result);*/
                //verify the password
        
            if($data)
            {
                     if($password == $data['user_password'])
                        {
                            //setting session
                            $_SESSION['UserEmail'] = $data['user_email'];
                            $_SESSION['Password'] = $data['user_password'];

                            //redirecting to Home page
                            header("Location:index.php");
                            exit();
                        }
                        else
                        {
                            // echo "Credential Doesn't Match";
                            $error = "Incorrect password! Try Again ";
                        }
            }
            else
            {
                $error = "User not found";
            }

    }
?> 
<div class="container sign-in">
    <form action="" method="POST">
        <div class="social-icons"> 
            <a href="#" class="icon"><i class="fab fa-google"></i></a>
            <a href="#" class="icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="icon"><i class="fab fa-instagram"></i></a>
        </div>
        <span>or use your email & password</span><br>
        <input type="email" name="useremail" placeholder= "Email"/><br>
        <input type="password" name="password" placeholder= "Password"/><br>
        <a href="#">Forget Your Password?</a><br>
        <button type= "submit" name="login" class="form-button">Sign In</button>
    </form>
    
    <p id="error1" ><?php echo $error; ?></p>
</div>