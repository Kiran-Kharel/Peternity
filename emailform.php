<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Assets\images\petlogo-fav.png" type="image/x-icon">
    <link rel="stylesheet" href="Assets/css/style.css">
    <title>Verify Email</title>
    <style>
        div{
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            
        }

        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 300px;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color:rgb(130, 244, 104);
            color: white;
            font-weight: bold;
            border: none;
        }
    </style>
</head>
<body>
    <div>
        <form method="POST" action="changePassword.php">
            <h3>Enter your email</h3>
            <input type="email" name="email" required placeholder="Enter your email">
            <button type="submit">Next</button>
        </form>
    </div>
</body>
</html>
