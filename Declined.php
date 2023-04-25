<?php
include("edit.php");

$id = $_GET['id'];

$query = "DELETE FROM issue where id ='$id'";
$data = mysqli_query($con,$query);

if($data){
    echo "<script>alert('Record not being Acceptable')</script>";
    ?>
    <meta http-equiv = "refresh" content = "0; url = http://localhost:8080/library/UserRequest.php"/>
    <?php
}
else{
    echo "Failed to Delete";
}

?>