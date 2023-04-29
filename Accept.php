<?php
include('edit.php');

if ($_POST['issue'] && $_GET['id']) {
    $id = $_GET['id'];
    $query = "SELECT * FROM issue WHERE Accept='0' AND id='$id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $UPDATE = "UPDATE issue SET Accept='1' WHERE id='$id'";
        $result = mysqli_query($con, $UPDATE);
        $BOOK = "SELECT BOOKNAME FROM issue Where id='$id'";
        $result = mysqli_query($con,$BOOK);
        $row = mysqli_fetch_assoc($result);
        if ($BOOK && $row) {
            $edit_query = "UPDATE edit SET NUMBER = NUMBER - 1 WHERE BOOKNAME='".$row['BOOKNAME']."'";
            $result = mysqli_query($con, $edit_query);
            echo "<script>alert('Data Inserted Successfully')
            window.location.href='UserRequest.php'</script>";
        } else {
            echo "<script>alert('Error')
        window.location.href='UserRequest.php'</script>";
        }
    } else {
        echo "<script>alert('Data not be Posted')
        window.location.href='UserRequest.php'</script>";
    }
} else {
    echo "<script>alert('Data not Inserted Successfully')
    window.location.href='UserRequest.php'</script>";
}
