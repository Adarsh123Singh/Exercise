<?php
include('Attach.php');
error_reporting(0);
session_start();

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($con,$_POST['name']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];

    // Get the new password value
$new_password = md5($_POST['new_password']);

// Update the password in the query
$select = "SELECT * FROM admin WHERE email = '$email' && password = '$new_password' or password='$pass'";


    $result = mysqli_query($con,$select);
    $num = mysqli_num_rows($result);

    if($num>0){

        $row = mysqli_fetch_array($result);

        if($row['user_type'] == 'admin'){

            $_SESSION['admin_name'] = $row['name'];
            header('location:Admin.php');

        }elseif($row['user_type'] == 'user'){

            $_SESSION['user_name'] = $row['name'];
            header('location:User.php');

        }

    }else{
        $error[] = 'Incorrect email or password!';
    }


};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    
    <div class="form-container">

        <form action="" method="POST">
            <h3>Login now</h3>
            <?php
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                };
            };
            ?>
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="submit" name="submit" value="Log in" class="form-btn">
            <p>Reset PASSWORD<a href="Forgot.php">Forgot Password</a></p>
            <p>Don't have an account? <a href="index.php">Registration now</a></p>
            
        </form>
    </div>
</body>
</html>