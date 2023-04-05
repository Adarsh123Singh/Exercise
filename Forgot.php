<?php
include('Attach.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Forgot Password</title>
    <link rel="stylesheet" href="style1.css">
  </head>
  <body>
  <div class="form-container">
        <form action="page.php" method="POST">
            <h3>Password Reset</h3>
            <input type="email" name="email" required placeholder="Enter your email">
            <a href="page.php"><input type="submit" name="send-reset-link" value="Send email" class="form-btn"></a>
        </form>
    </div>
  </body>
</html>