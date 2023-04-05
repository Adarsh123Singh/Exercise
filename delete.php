<?php
include("edit.php");

$id = $_GET['id'];

$query = "DELETE FROM edit where id ='$id'";
$data = mysqli_query($con,$query);

if($data){
    echo "<script>alert('Record Deleted')</script>";
    ?>
    <meta http-equiv = "refresh" content = "0; url = http://localhost:8080/library/admin.php"/>
    <?php
}
else{
    echo "Failed to Delete";
}

?>