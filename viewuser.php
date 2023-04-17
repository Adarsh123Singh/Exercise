<?php 
error_reporting(0);
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

    <title>view Details</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a href="http://localhost:8080/LIBRARY/User.php"><input type="submit" value="Back" class="btn btn-light"></a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">MORE</button>
        </div>
    </nav>
    <div class="container">
        <form action="#" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                <label for="recipient-name" class="col-form-label"><b>Upload Image</b></label>
                <label for="recipient-name" class="col-form-label"><?php
                $Upd = $result['img_post'];
               echo "<img src='$Upd'>";
                ?></label>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Book Name:</b></label>
                    <label for="recipient-name" class="col-form-label"><?php echo
                    $result['BOOKNAME'] ?></label>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Book Title:</b></label>
                    <label for="recipient-name" class="col-form-label"><?php echo $result['BOOKTITLE']; ?></label>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Author Name:</b></label>
                    <label for="recipient-name" class="col-form-label"><?php echo $result['AUTHERNAME']; ?></label>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Book Type</b></label>
                    <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><?php 
                                if($result['BOOKTYPE']=='Fiction'){
                                    echo "Fiction";
                                }
                                else{
                                    echo "Non-Fiction";
                                }
                            ?></label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Book Addition</b></label>
                    <label for="recipient-name" class="col-form-label"><?php echo $result['BOOKADDITION']; ?></label>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label"><b>Description/About</b></label>
                    <label for="recipient-name" class="col-form-label"><?php echo $result['DESCRIPTION']; ?></label>
                </div>
        </form>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">More Option's</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
            <p>Select Option <select name="Book" id="Book">
                <option value="" hidden></option>
                <option value="Want to read">Want to Read</option>
                <option value="Mark as read">Mark as read</option>
                <option value="Submit">Submit</option>
            </select></p>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal">Save</button>
      </div>
    </div>
  </div>
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
    if(isset($_POST['update']))
    {

        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "Images/".$filename;  
        move_uploaded_file($tempname,$folder);

        $BOOKNAME       = $_POST['BOOKNAME'];
        $BOOKTITLE      = $_POST['BOOKTITLE'];
        $AUTHERNAME       = $_POST['AUTHERNAME'];
        $BOOKTYPE       = $_POST['BOOKTYPE'];
        $BOOKADDITION   = $_POST['BOOKADDITION'];
        $DESCRIPTION = $_POST['DESCRIPTION'];

if ($BOOKNAME !="" && $BOOKTITLE !="" && $AUTHERNAME !=="" && $BOOKTYPE !="" && $BOOKADDITION !="" && $DESCRIPTION !="") {

    $query = "UPDATE edit SET img_post='$folder', BOOKNAME='$BOOKNAME',BOOKTITLE='$BOOKTITLE',AUTHERNAME='$AUTHERNAME',BOOKTYPE='$BOOKTYPE',BOOKADDITION='$BOOKADDITION',DESCRIPTION='$DESCRIPTION' WHERE id='$id'";
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