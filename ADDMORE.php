<?php
include('Attach.php');
error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail($email, $v_code)
{
    require("PHPMailer/PHPMailer.php");
    require("PHPMailer/SMTP.php");
    require("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'adarsh5647singh@gmail.com';                     //SMTP username
        $mail->Password   = 'xihdyvmldzbjaulq';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        $mail->setFrom('adarsh5647singh@gmail.com', 'E-Library');
        $mail->addAddress($email);
    
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'E-mail Verification for E-Library';
        $mail->Body    = "Thanks for registration!
        Click the link below to verify the email address 
        <a href='http://localhost:8080/LIBRARY/verify.php?email=$email&v_code=$v_code'>Verify</a>";
        $mail->send();
        return true;
        }
        catch (Exception $e) {
            return false;
        }

}
if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($con,$_POST['name']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];
    $v_code = bin2hex(random_bytes(12));
    $new_pass = md5($_POST['new_password']);
    $select = "SELECT * FROM admin WHERE email = '$email' && password = '$new_pass' or password='$pass'";
    $result = mysqli_query($con,$select);
    $num = mysqli_num_rows($result);

    if($num > 0) {
        $error[] = 'User already exists';
    } else {
        if($pass != $cpass) {
            $error[] = 'Passwords do not match!';
        } else {
            $insert = "INSERT INTO admin(name, email, password, user_type, verification_code, is_verified) VALUES('$name','$email', '$pass', '$user_type','$v_code','0')";
            mysqli_query($con, $insert) && sendMail($_POST['email'], $v_code);
            header('location: Verifyemail.php');
        }
    }
    
    // Code to update password in $select query
    if(isset($_POST['update_password'])) {
        $new_pass = md5($_POST['new_password']);
        $confirm_pass = md5($_POST['confirm_password']);
        if($new_pass != $confirm_pass) {
            $error[] = 'New Password and Confirm Password do not match!';
        } else {
            $update_query = "UPDATE admin SET password = '$new_pass' WHERE email = '$email'";
            mysqli_query($con, $update_query);
            header('location: success.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="form-container">

        <form action="" method="POST">
            <h3>Add Users or admin</h3>
            <?php
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                };
            };
            ?>
            <input type="text" name="name" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="password" name="cpassword" required placeholder="Confirm your password">
            <select name="user_type">
                <option value="admin">admin</option>
            </select>
            <input type="submit" name="submit" value="Register Now" class="form-btn">
            <p>Already have an account? <a href="LOGIN.php">Login now</a></p>
        </form>

    </div>

</body>
</html>