<?php
include('Attach.php');
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
        $mail->Password   = 'ieksvgqkqbfnbmkj';                               //SMTP password
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

$admin_result = mysqli_query($con, "SELECT * FROM admin");
$admin_num = mysqli_num_rows($admin_result);
$admin_exists = ($admin_num > 0);

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con,$_POST['name']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];
    $v_code = bin2hex(random_bytes(12));

    if($user_type == 'admin' && $admin_num > 0) {
        $error[] = 'An admin account already exists';
    } else {
        $select = "SELECT * FROM admin WHERE email = '$email'";
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
            <h3>Regitration Form</h3>
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
    <?php if (!$admin_exists): ?>
    <option value="admin">admin</option>
    <?php endif; ?>
    <option value="user">user</option>
</select>
            <input type="submit" name="submit" value="Register Now" class="form-btn">
            <p>Already have an account? <a href="LOGIN.php">Login now</a></p>
        </form>

    </div>

</body>
</html>