<?php 
include("edit.php"); 

$id = $_GET['id'];

$query = "SELECT * FROM edit where id='$id'";
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
            <a href="http://localhost:8080/LIBRARY/Subadmin.php"><input type="submit" value="Back" class="btn btn-light"></a>
            <span class="navbar mb-0 h1">Update Book Details</span>
        </div>
    </nav>
    <div class="container">
        <form action="#" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Change Image</label>
                    <input type="file" name="uploadfile"><br>
                    <img src="<?php echo $result['img_post']; ?>" class="col-form-label" value="Change Image">
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Book Name</label>
                    <input type="text" value="<?php echo
                    $result['BOOKNAME'] ?>" class="form-control" name="BOOKNAME" required>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Book Title</label>
                    <input type="text" value="<?php echo $result['BOOKTITLE']; ?>" class="form-control" name="BOOKTITLE" requtred>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Author Name</label>
                    <input type="text" value="<?php echo $result['AUTHERNAME']; ?>" class="form-control" name="AUTHERNAME" required>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">No. of Books</label>
                    <input type="text" value="<?php echo $result['NUMBER']; ?>" class="form-control" name="NUMBER" required>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Book Type</label>
                    <div class="mb-3">

                        <select class="form-select" aria-label="Default select example" name="BOOKTYPE" required>
                            <option selected></option>
                            <option value="Fiction"
                            <?php 
                                if($result['BOOKTYPE']=='Fiction'){
                                    echo "selected";
                                }
                            ?>
                            >Fiction</option>
                            <option value="Non-Fiction"
                            <?php 
                                if($result['BOOKTYPE']=='Non-Fiction'){
                                    echo "selected";
                                }
                            ?>
                            >Non-Fiction</option>
                        </select>

                    </div>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Book Addition</label>
                    <input type="text" value="<?php echo $result['BOOKADDITION']; ?>" class="form-control" name="BOOKADDITION" required>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Description/About</label>
                    <textarea class="form-control" name="DESCRIPTION" required><?php echo $result['DESCRIPTION']; ?>
                    </textarea>
                </div>
                <input type="submit" value="Update" class="btn btn-primary" name="update">
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>
</html>

<?php
if (isset($_POST['update'])) {
    // Get the values from the form
    $BOOKNAME = $_POST['BOOKNAME'];
    $BOOKTITLE = $_POST['BOOKTITLE'];
    $AUTHERNAME = $_POST['AUTHERNAME'];
    $NUMBER = $_POST['NUMBER'];
    $BOOKTYPE = $_POST['BOOKTYPE'];
    $BOOKADDITION = $_POST['BOOKADDITION'];
    $DESCRIPTION = $_POST['DESCRIPTION'];

    // Check if a new file was uploaded
    if ($_FILES["uploadfile"]["error"] == UPLOAD_ERR_OK) {
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "images/".$filename;
        move_uploaded_file($tempname,$folder);
    } else {
        // No file was uploaded, so don't update the image field
        $folder = null;
    }

    // Update the database
    if ($BOOKNAME != "" && $BOOKTITLE != "" && $AUTHERNAME != "" && $NUMBER != "" && $BOOKTYPE != "" && $BOOKADDITION != "" && $DESCRIPTION != "") {
        $query = "UPDATE edit SET";
        if ($folder != null) {
            $query .= " img_post='$folder',";
        }
        $query .= " BOOKNAME='$BOOKNAME', BOOKTITLE='$BOOKTITLE', AUTHERNAME='$AUTHERNAME', NUMBER='$NUMBER', BOOKTYPE='$BOOKTYPE', BOOKADDITION='$BOOKADDITION', DESCRIPTION='$DESCRIPTION' WHERE id='$id'";
        $data = mysqli_query($con, $query);
        if ($data) {
            echo "<script>alert('Record Updated')</script>";
            ?>
            <meta http-equiv="refresh" content="0; url=http://localhost:8080/LIBRARY/Subadmin.php">
            <?php
        } else {
            echo "Something Wrong";
        }
    } else {
        echo "<script>alert('First Fill Full Book Details')</script>";
    }
}
?>