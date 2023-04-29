<?php
include('edit.php');

if ($_POST['mark'] &&  $_GET['id']) {
    $id = $_GET['id'];
    $query = "SELECT * FROM issue WHERE MARK='0' AND id='$id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        if (mysqli_num_rows($result) != 0) {
            if ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $UPDATE = "UPDATE issue SET MARK='1' WHERE id='$id'";
                if (mysqli_query($con, $UPDATE)) {
                    echo "<script>
                            alert('Mark as read')
                            window.location.href='UserBook.php';</script>";
                } else {
                    echo "<script>
                            alert('Cannot run query')
                            window.location.href='UserBook.php';</script>";
                }
            }
        } else {
            echo "<script>
                    alert('No Pending Requests Found')
                    window.location.href='UserBook.php';</script>";
        }
    } else {
        echo "<script>
                alert('Cannot run query')
                window.location.href='UserBook.php';</script>";
    }
} else {
    echo "<script>
                alert('Data not inserted')
                window.location.href='UserBook.php';</script>";
}
?>