<?php 
include("Attach.php"); 

$id = $_GET['id'];

$query = "SELECT * FROM admin where id='$id'";
$data = mysqli_query($con, $query);
$total = mysqli_num_rows($data);

$result = mysqli_fetch_assoc($data);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Edit Details</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a href="http://localhost:8080/library/userdeatils.php"><input type="submit" value="Back" class="btn btn-light"></a>
            <span class="navbar mb-0 h1">Update User Details</span>
        </div>
    </nav>
    <div class="container">
        <form action="#" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">User Name</label>
                    <input type="text" value="<?php echo
                    $result['name'] ?>" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">User Email</label>
                    <input type="text" value="<?php echo $result['email']; ?>" class="form-control" name="email" requtred>
                </div>
                <input type="submit" value="Update" class="btn btn-primary" name="update">
        </form>
    </div>
</body>
</html>

<?php
    if(isset($_POST['update']))
    {
        $name       = $_POST['name'];
        $email      = $_POST['email'];
        $user_type  = $_POST['user_type'];

if ($name !="" && $email !="" && $user_name !=="") {

    $query = "UPDATE admin SET name='$name',email='$email',user_type='$user_type' WHERE id='$id'";
    $data = mysqli_query($con,$query);
    if ($data) {
        echo "<script>alert('Record Updated')</script>";
        ?>
            <meta http-equiv = "refresh" content = "0; url = http://localhost:8080/library/userdeatils.php" />
        <?php
    } else {
        echo "Something Wrong";
    }
}
    else{
        echo "<script>alert('First Fill Full User Details')</script>";
    }
}
?>