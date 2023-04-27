<?php
error_reporting(E_ALL);
include("edit.php");
include('ATTACH.php');
$id = $_GET['id'];

session_start();
$user_name= $_SESSION['user_name'];
$user_email = $_SESSION['email'];
$query = "SELECT * FROM edit where id ='$id' AND issueuser='0'";
$data = mysqli_query($con,$query);


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Book Details</title>
    <style>
        table {
            background-color: lightgrey;
            margin-top: 20px;
        }

        h2 {
            margin: 50px;
        }

        select {
            padding: 0 500px;
        }

        .con {
            align-items: inline-block;
        }

        .cont,
        .cont1 {
            margin: 20px 590px 20px 630px;
        }
        img {
    height: 100px;
    width: 100px;
}
td{
    padding: 5px;
}
    </style>

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Issue Book</span>
            <a href="LOGOUT.php"><button type="button" class="btn btn-outline-primary">Log Out</button></a>
        </div>
    </nav>
</body>

</html>
<?php

if($data) {
    if(mysqli_num_rows($data)!=0){

    ?>
    <center>
        <table border='3' cellspacing='7' width=88%>
            <tr>
                <th width=2% height=2%>S.No.</th>
                <th width=11% height=2%>USER NAME</th>
                <th width=15% height=2%>USER EMAIL</th>
                <th width=5% height=2%>Images</th>
                <th width=15% height=2%>Book Name</th>
                <th width=10%>No. of Books</th>
                <th width=15% height=2%>Author Name</th>
                <th width=15% height=2%>Operations</th>
            </tr>
        <?php
            $a=1;
while ($result = mysqli_fetch_assoc($data)) {
    $id=$result['id'];
    $UPDATE = "UPDATE edit SET issueuser='1' WHERE id=$id";
    if(mysqli_query($con, $UPDATE)) {
        echo "<tr>                   
                    <form method='POST' action='send.php' enctype='multipart/form-data'>
                    <td>$a</td>
                    <td><input type='text' value='$user_name' name='name' readonly></td>
                    <td><input type='text' value='$user_email' name='email' readonly></td>
                    <td><input type='img' value='$result[img_post]' name='img_post' readonly></td>
                    <td><input type='text' value='$result[BOOKNAME]' name='BOOKNAME' readonly></td>
                    <td><input type='text' value='$result[NUMBER]' name='NUMBER' readonly></td>
                    <td><input type='text' value='$result[AUTHERNAME]' name='AUTHORNAME' readonly></td>
                    <td>

                    <input type='submit' name='SEND_REQUEST' value='Send Request' class='btn btn-danger'>
                    </form>

                    </td>
                </tr>";
        $a++;
    }
}
}
}
        ?>
        </table>
    </center>