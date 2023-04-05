<?php
include("Attach.php");

$id = $_GET['id'];

$query = "DELETE FROM admin where id ='$id'";
$data = mysqli_query($con,$query);

if($data){
    echo "<script>alert('Record Deleted')</script>";
    ?>
    <meta http-equiv = "refresh" content = "0; url = http://localhost:8080/library/userdeatils.php"/>
    <?php
}
else{
    echo "Failed to Delete";
}

?>