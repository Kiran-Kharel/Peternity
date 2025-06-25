<?php
    session_start();
    error_reporting(E_ALL);
    require_once("connect.php");
    $error = "";
    $data = null;
    if(isset($_POST['login']))
    {
        //sql injection prevention
        $userEmail = $conn->real_escape_string(trim($_POST['user_email']));
        $userPwd = $conn->real_escape_string(trim($_POST['user_password']));
        $password = md5($userPwd);
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
		
        // echo $data['user_id'];  
           /*echo"<pre>";
           print_r($result);*/
                //verify the password
        
            if($data)
            {
                     if($password == $data['user_password'])
                        {
                            //setting session
                            $_SESSION['UserEmail'] = $data['user_email'];
                            $_SESSION['user_id'] = $data['user_id'];
                            header("Location: userprofile.php");
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
<!-- <div class="container sign-in">
    <form action="" method="POST">
        <div class="social-icons">
            <a href="#" class="icon"><i class="fab fa-google"></i></a>
            <a href="#" class="icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="icon"><i class="fab fa-instagram"></i></a>
        </div>
        <span>or use your email & password</span><br>
        <input type="email" name="useremail" placeholder="Email" /><br>
        <input type="password" name="password" placeholder="Password" /><br>
        <a href="#">Forget Your Password?</a><br>
        <button type="submit" name="login" class="form-button">Sign In</button>
    </form>

\</div> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css">
    <link rel="shortcut icon" href="Assets\images\petlogo-fav.png" type="image/x-icon">
    <link href="navbar.css" rel="stylesheet">
    <style>
    body {
        background-color: #DFFBF3;
    }
    .auth-card {
        background: #fff;
        border: 2px solid #213F12;
        border-radius: 12px;
    }
    .auth-card h3 {
        color: #213F12;
    }
    .btn-auth {
        background-color: #213F12;
        color: white;
    }
    .btn-auth:hover {
        background-color: #1b3510;
    }
    .password-field {
            position: relative;
            margin-bottom: 20px;
    }
    #user_pwd {
            width: 100%;
            padding: 10px 40px 10px 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
    }
    .toggle-icon {
        position: absolute;
        right: 12px;
        top: 73%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #555;
  }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="col-md-6 col-lg-5">
            <div class="card auth-card shadow p-4">
                <h3 class="text-center mb-4">Log In</h3>
                <form action="" method="POST">
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="user_email" required>
                    </div>
                    <div class="password-field ">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="user_pwd" name="user_password" required>
                        <i class="fa-solid fa-eye toggle-icon" onclick="togglePwd('user_pwd', this)"></i>
                    </div>
                    <span id="error" class="text-danger"><?php echo $error; ?></span>
                    <button type="submit" name="login" class="btn btn-success w-100">Login</button>
                    <div class="text-center mt-3">
                        <a href="signup.php">Don't have an account? Sign up</a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</body>
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

</html>