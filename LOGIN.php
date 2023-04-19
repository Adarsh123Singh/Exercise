<?php
session_start();
include('Attach.php');
if(isset($_POST['submit'])){

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = md5($_POST['password']);
    $user_type = $_POST['user_type'];
    
    $new_password = isset($_POST['new_password']) ? md5($_POST['new_password']) : '';

    $select = "SELECT * FROM admin WHERE email = '$email' && password IN ('$new_password', '$pass')";
    $result = mysqli_query($con, $select);
    $num = mysqli_num_rows($result);
    if($num > 0){
        $row = mysqli_fetch_assoc($result);
        if($row['is_verified']==1){
            if($row['user_type'] === $user_type){
                if($user_type === 'admin' && $row['email'] == $email && $row['password'] === $pass){
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_type'] = 'admin';
                    header("location: Admin.php");
                }
                elseif($user_type==='user') {
                    $_SESSION['user_name'] = $row['name'];
                    header("location:User.php?email=$email");
                }
                else{
                    $_SESSION['user_name'] = $row['name'];
                    header("location:Subadmin.php?email=$email");
                }
            } else {
                $error[] = 'Incorrect user type selected!';
            }
        }else{
            $error[] = 'Email not Verified';
        }
    } else {
        $error[] = 'Incorrect email or password!';
    }
}
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
            <select name="user_type">
                <option value="admin">admin</option>
                <option value="user">user</option>
                <option value="sub_admin">sub_admin</option>
            </select>
            <input type="submit" name="submit" value="Log in" class="form-btn">
            <p>Reset PASSWORD<a href="Forgot.php">Forgot Password</a></p>
            <p>Don't have an account? <a href="index.php">Registration now</a></p>
            
        </form>
    </div>
</body>
</html>