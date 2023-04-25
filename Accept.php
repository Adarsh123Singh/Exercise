<?php 
    include('edit.php');
    
    if($_POST['issue'] &&  $_GET['id'])
    {
        $id = $_GET['id'];
        $query = "SELECT * FROM issue WHERE Accept='0' AND id='$id'";
        $result = mysqli_query($con, $query);
        var_dump($result);
        if($result)
        {
            if(mysqli_num_rows($result) != 0){
                if($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $UPDATE = "UPDATE issue SET Accept='1' WHERE id='$id'";
                    if(mysqli_query($con,$UPDATE)){
                        echo "<script>
                            alert('Data Sent to User Successfully')
                            window.location.href='UserRequest.php';</script>";
                    }
                    else{
                        echo "<script>
                            alert('Cannot run query')
                            window.location.href='UserRequest.php';</script>";
                    }
                }
            }
            else{
                echo "<script>
                    alert('No Pending Requests Found')
                    window.location.href='UserRequest.php';</script>";
            }
        }
        else{
            echo "<script>
                alert('Cannot run query')
                window.location.href='UserRequest.php';</script>";
        }
    }
    else{
        echo "<script>
            alert('Data not inserted')</script>";
    }
?>