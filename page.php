<?php
include('Attach.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail($email,$reset_token){
    require('PHPMailer/PHPMailer.php');
    require('PHPMailer/SMTP.php');
    require('PHPMailer/Exception.php');

    $mail = new PHPMailer(true);

    try {
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'adarsh5647singh@gmail.com';                     //SMTP username
        $mail->Password   = 'ieksvgqkqbfnbmkj';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('adarsh5647singh@gmail.com', 'E-Library');
        $mail->addAddress($email);     //Add a recipient
    
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Password Reset link with E-Library';
        $mail->Body    = "We got a request from $email to reset your password!<br>
        Click the Link Below: <br>
        <a href='http://localhost:8080/library/Updatepassword.php?email=$email&reset_token=$reset_token'>
            Reset Password
        </a>";
    
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
    
}
if(isset($_POST['send-reset-link'])){
    $query="SELECT * FROM admin WHERE email='$_POST[email]'";
    $result = mysqli_query($con,$query);
    if($result){
        if(mysqli_num_rows($result)==1){
            $reset_token=bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/kolkata');
            $date=date("Y-m-d");
            $query="UPDATE admin SET resettoken='$reset_token',`resettokenexpire`='$date' WHERE email='$_POST[email]'";
            if(mysqli_query($con,$query) && sendmail($_POST['email'],$reset_token)){
                echo "<script>
            alert('Password Reset link Sent to mail');
            window.location.href='index.php';
        </script>
        ";
            }
            else{
                echo "<script>
            alert('Server Down! Try it Later');
            window.location.href='index.php';
        </script>
        ";
            }
        }
        else{
            echo "<script>
            alert('Email Not Found');
            window.location.href='index.php';
        </script>
        ";
        }
    }
    else{
        echo "<script>
            alert('cannot run query');
            window.location.href='index.php';
        </script>
        ";
    }
}
?>