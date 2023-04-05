<?php 
error_reporting(0);
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

    <title>User Details</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a href="http://localhost:8080/LIBRARY/userdeatils.php"><input type="submit" value="Back" class="btn btn-light"></a>
            <span class="navbar mb-0 h1">User Details</span>
        </div>
    </nav>
    <div class="container">
        <form action="#" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>User Name:</b></label>
                    <label for="recipient-name" class="col-form-label"><?php echo
                    $result['name'] ?></label>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Email:</b></label>
                    <label for="recipient-name" class="col-form-label"><?php echo $result['email']; ?></label>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>User Type</b></label>
                    <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><?php 
                                if($result['user_type']=='admin'){
                                    echo "admin";
                                }
                                else{
                                    echo "user";
                                }
                            ?></label>
                    </div>
                </div>
        </form>
    </div>

    
</body>
</html>

<?php
    if(isset($_POST['update']))
    {

        

        $name       = $_POST['name'];
        $email     = $_POST['email'];
        $user_type       = $_POST['user_type'];

if ($name !="" && $email !="" && $user_type !=="") {

    $query = "UPDATE admin SET name='',BOOKTITLE='$BOOKTITLE',AUTHERNAME='$AUTHERNAME',BOOKTYPE='$BOOKTYPE',BOOKADDITION='$BOOKADDITION',DESCRIPTION='$DESCRIPTION' WHERE id='$id'";
    $data = mysqli_query($con,$query);
    if ($data) {
        echo "<script>alert('Record Updated')</script>";
        ?>
            <meta http-equiv = "refresh" content = "0; url = http://localhost:8080/library/admin.php" />
        <?php
    } else {
        echo "Something Wrong";
    }
}
    else{
        echo "<script>alert('First Fill Full Book Details')</script>";
    }
}
?>