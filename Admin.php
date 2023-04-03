<?php

include ('Attach.php');

session_start();

if(!isset($_SESSION['admin_name'])){
    header('location:LOGIN.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="container">

        <div class="content">
            <h3>hi, <span>admin</span></h3>
            <h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
            <p>This is an admin page</p>
            <a href="LOGIN.php" class="btn">Log in</a>
            <a href="REGISTRATION.php" class="btn">REGISTRATION</a>
            <a href="LOGOUT.php" class="btn">Log out</a>
        </div>
    </div>
</body>
</html>