<?php
include("edit.php");

$id = $_GET['id'];

$query = "SELECT * FROM edit where id ='$id'";
$data = mysqli_query($con,$query);

if($data){
    echo "<script>alert('Issue Request Sent')</script>";
    ?>
    <meta http-equiv = "refresh" content = "0; url = http://localhost:8080/library/Subadmin.php"/>
    <?php
}
else{
    echo "Failed to Issue";
}

?>