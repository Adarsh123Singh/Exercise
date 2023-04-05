<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    
    <?php
        include 'Attach.php';

        if(isset($_GET['email']) && isset($_GET['reset_token'])){
            date_default_timezone_set('Asia/Kolkata');
            $date=date("Y-m-d");
            $query="SELECT * FROM admin WHERE email='$_GET[email]' AND resettoken='$_GET[reset_token]' AND resettokenexpire='$date'";
            $result = mysqli_query($con,$query);
            if($result){
                if(mysqli_num_rows($result)==1){
                  echo  "<div class=form-container>
                  <form method='POST'>
                  <h3>Create New Password</h3>
                  <input type='password' placeholder='New Password' name='Password'>
                  <input type='submit' name='updatepassword' value='UPDATE' class='form-btn'>
                  <input type='hidden' name='email' value='$_GET[email]'>
                  </form>
                  </div>";
                }
                else{
                    echo "<script>
            alert('Invalid or Expired Link');
            window.location.href='index.php';
        </script>
        ";
                }
            }
            else{
                echo "<script>
                        alert('Server Down! Try it Later');
                        window.location.href='index.php';
                    </script>
        ";
            }
        }
    ?>

    <?php 
    
    if(isset($_POST['updatepassword'])){
        if(empty($_POST['Password'])){
            echo "<script>
                        alert('Please enter a new password');
                        window.location.href='Updatepassword.php?email=".$_POST['email']."&reset_token=".$_GET['reset_token']."';
                    </script>";
            exit;
        }
        $pass=md5($_POST['password']);
        $update = "UPDATE admin SET password='$pass',resettoken=NULL,resettokenexpire=NULL WHERE email='$_POST[email]'";
        
        if(mysqli_query($con,$update))
        {
            echo "<script>
                        alert('Password Updated Successfully');
                        window.location.href='index.php';
                    </script>";
        }
        else{
            echo "<script>
                        alert('Server Down! Try it Later');
                        window.location.href='index.php';
                    </script>";
        }
    }
    
    ?>

</body>
</html>