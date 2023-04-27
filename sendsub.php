<?php
error_reporting(E_ALL);
include('edit.php');

if(isset($_POST['SEND_REQUEST'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $img_post = $_POST['img_post'];
    $BOOKNAME   = $_POST['BOOKNAME'];
    $NUMBER = $_POST['NUMBER'];
    $AUTHORNAME       = $_POST['AUTHORNAME'];
    if($name!='' && $email!='' && $BOOKNAME!='' && $AUTHORNAME!=''){
        $query = "INSERT INTO issue(name,email,img_post,BOOKNAME,NUMBER,AUTHORNAME) VALUES('$name', '$email','$img_post','$BOOKNAME','$NUMBER','$AUTHORNAME')";
    $data = mysqli_query($con, $query);
    if($data){
                echo "<script>alert('Request sent successfully')</script>";
                ?>
    <meta http-equiv = "refresh" content = "0; url = http://localhost:8080/library/Subadmin.php"/>
    <?php
            }else{
                echo "SOMETHING WRONG";
            }
            }else{
                echo "DATA not Inserted";
            }
        }
else{
    echo "Submission Error";
}
?>