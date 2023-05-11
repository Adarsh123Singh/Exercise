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
    <div class="container">
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label"><b>Upload Image</b></label>
                <input type="file" required name="uploadfile">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Book Name</b></label>
                    <input type="text" required class="form-control" name="BOOKNAME">
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Book Title</b></label>
                    <input type="text" required class="form-control" name="BOOKTITLE">
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Author Name</b></label>
                    <input type="text" required class="form-control" name="AUTHERNAME">
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>No. of Books</b></label>
                    <input type="text" required class="form-control" name="NUMBER">
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Book Type</b></label>
                    <div class="mb-3">
                        <select class="form-select" aria-label="Default select example" required name="BOOKTYPE">
                            <option selected hidden></option>
                            <option value="Fiction">Fiction</option>
                            <option value="Non-Fiction">Non-Fiction</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Book Addition</b></label>
                    <input type="text" required class="form-control" name="BOOKADDITION">
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label"><b>Description/About</b></label>
                    <textarea class="form-control" required name="DESCRIPTION"></textarea>
                </div>
                <input type="submit" value="Save" class="btn btn-primary" name="submit">
        </form>
    </div>
</body>
</html>

<?php

include('edit.php');
if (isset($_POST['submit'])) {

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "Images/" . $filename;
    move_uploaded_file($tempname, $folder);

    $BOOKNAME      = $_POST['BOOKNAME'];
    $BOOKTITLE      = $_POST['BOOKTITLE'];
    $AUTHERNAME       = $_POST['AUTHERNAME'];
    $NUMBER         = $_POST['NUMBER'];
    $BOOKTYPE       = $_POST['BOOKTYPE'];
    $BOOKADDITION   = $_POST['BOOKADDITION'];
    $DESCRIPTION = $_POST['DESCRIPTION'];

    if ($BOOKNAME != "" && $BOOKTITLE != "" && $AUTHERNAME !== "" && $NUMBER != "" && $BOOKTYPE != "" && $BOOKADDITION != "" && $DESCRIPTION != "") {
        $query = "INSERT INTO edit (img_post, BOOKNAME, BOOKTITLE, AUTHERNAME, NUMBER, BOOKTYPE, BOOKADDITION, DESCRIPTION) VALUES ('$folder','$BOOKNAME', '$BOOKTITLE', '$AUTHERNAME','$NUMBER', '$BOOKTYPE', '$BOOKADDITION', '$DESCRIPTION')";

        $data = mysqli_query($con, $query);
        if ($data) {
            echo "<script>alert('Data inserted Successfully');
                </script>";
?>
            <meta http-equiv="refresh" content="0; url = http://localhost:8080/library/Admin.php">
<?php
        } else {
            echo "Something Wrong";
        }
    } else {
        echo "<script>alert('First Fill Full Book Details')</script>";
    }
}
?>