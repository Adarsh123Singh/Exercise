<?php
include('edit.php');

if ($_POST['submit'] &&  $_GET['id']) {
    $id = $_GET['id'];
    $query = "SELECT * FROM issue WHERE SUBMIT='0' AND id='$id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        if (mysqli_num_rows($result) != 0) {
            if ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $date = date('Y-m-d');
                $UPDATE = "UPDATE issue SET SUBMIT='1' , Date='$date' WHERE id='$id'";
                $result = mysqli_query($con, $UPDATE);
                $BOOK = "SELECT BOOKNAME from issue WHERE id=$id";
                $result = mysqli_query($con, $BOOK);
                $row = mysqli_fetch_assoc($result);
                if ($BOOK && $row) {
                    $edit_query = "UPDATE edit SET NUMBER = NUMBER + 1 , issuesub = '0' WHERE BOOKNAME = '".$row['BOOKNAME']."'";
                    $result=mysqli_query($con,$edit_query);
                    
                    echo "<script>
                            alert('BOOK SUBMITTED SUCCESSFULLY')
                            window.location.href='SubadminBook.php';</script>";
                } else {
                    echo "<script>
                            alert('Cannot run query')
                            window.location.href='SubadminBook.php';</script>";
                }
            }
        } else {
            echo "<script>
                    alert('No Pending Requests Found')
                    window.location.href='SubadminBook.php';</script>";
        }
    } else {
        echo "<script>
                alert('Cannot run query')
                window.location.href='SubadminBook.php';</script>";
    }
} else {
    echo "<script>
                alert('Data not inserted')
                window.location.href='SubadminBook.php';</script>";
}
