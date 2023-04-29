<?php 
    include('edit.php');
    if($_POST['wish'] &&  $_GET['id'])

    {
        $id = $_GET['id'];
        $query = "SELECT * FROM edit WHERE wishuser='0' AND id='$id'";
        $result = mysqli_query($con, $query);
        if($result)
        {
            if(mysqli_num_rows($result) != 0){
                if($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $UPDATE = "UPDATE edit SET wishuser='1' WHERE id='$id'";
                    if(mysqli_query($con,$UPDATE)){
                        echo "<script>
                            alert('wish to read')
                            window.location.href='User.php';</script>";
                    }
                    else{
                        echo "<script>
                            alert('Cannot run query')
                            window.location.href='User.php';</script>";
                    }
                }
            }
            else{
                echo "<script>
                    alert('No Pending Requests Found')
                    window.location.href='User.php';</script>";
            }
        }
        else{
            echo "<script>
                alert('Cannot run query')
                window.location.href='User.php';</script>";
        }
    }
    else{
        echo "<script>
                alert('Data not inserted')";
                
    }
?>