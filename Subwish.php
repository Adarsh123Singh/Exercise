<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>User Wish Details</title>
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
    padding: 7px;
}
form{
    margin: 5px;
}
    </style>

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Wish to Read</span>
            <a href="LOGOUT.php"><button type="button" class="btn btn-outline-primary">Log Out</button></a>
        </div>
    </nav>
    <div class="con">
        <form method="POST" action="">
            <div class="input-group-text mb-3 cont1">
                <input class="input-group-text" type="text" name="search" placeholder="Search Books" required>
                <button class="btn btn-outline-success" name="submit" type="submit">Search</button>
            </div>
        </form>
        <form class="d-flex" method="GET" action="">
            <div class="input-group mb-3 cont">
                <select name="sort_alphabet" class="input-group-text">
                    <option value="">--SELECT OPTION</option>
                    <option value="a-z" <?php if (isset($_GET['sort_alphabet']) && $_GET['sort_alphabet'] == 'a-z')
                                        echo "selected"; ?>>A-Z</option>
                    <option value="z-a" <?php if (isset($_GET['sort_alphabet']) && $_GET['sort_alphabet'] == 'z-a')
                                        echo "selected"; ?>>Z-A</option>
                </select>
                <button class="input-group-text btn btn-light">sort</button>
            </div>
        </form>
    </div>

</body>

</html>

<?php
session_start();
    include('edit.php');
    $sort_option = "";
    $search = '';
    if (isset($_POST['submit'])) {
        $search = $_POST['search'];
    }

    if (isset($_GET['sort_alphabet'])) {
        if ($_GET['sort_alphabet'] == 'a-z') {
            $sort_option = "ASC";
        } elseif ($_GET['sort_alphabet'] == 'z-a') {
            $sort_option = "DESC";
        }
    }
    $count_query = "SELECT COUNT(*) as count FROM edit WHERE id like '%$search%' or BOOKNAME like '%$search%' or AUTHERNAME like '%$search%'";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total = $count_row['count'];
    $sql = "SELECT * FROM edit WHERE id like '%$search%' Or BOOKNAME like '%$search%' Or AUTHERNAME like '%$search%' ORDER BY id $sort_option";
    $data = mysqli_query($con, $sql);
    if ($total != 0) {
        ?>
    <center>
        <table border='3' cellspacing='7' width=63%>
            <tr>
                <th width=4%>S.No.</th>
                <th width=5%>Images</th>
                <th width=9%>Book Name</th>
                <th width=9%>Author Name</th>
                <th width=9%>Book Title</th>
                <th width=9%>No. of Books</th>
                <th width=18%>Operations</th>
                
            </tr>
        <?php
    $a=1;
    while ($result = mysqli_fetch_assoc($data)) {
if($result['wishsub'] =='1') {


    echo "<tr>
                    <td>$a</td>
                    <td><img src='" . $result['img_post'] . "'></td>
                    <td>" . $result['BOOKNAME'] . "</td>
                    <td>" . $result['AUTHERNAME'] . "</td>
                    <td>" . $result['BOOKTITLE'] . "</td>
                    <td>" . $result['NUMBER'] . "</td>
                    <td><a href='viewsub.php?id=$result[id]'><input type='submit' value='View' class='btn btn-info'></a>";
                    if($result['issuesub'] == '0'){
                        echo "<a href='issuesubadmin.php?id=$result[id]'><input type='submit' value='Book Issue' class='btn btn-dark'></a>";
                    }else{
                        echo "<a href=''><input type='submit' value='Book Issued' class='btn btn-dark' disabled></a>";
                    }
                    
                    echo 
                    "</td>
                </tr>";

        $a++;
    }
}
    }
     else {
        echo "No Records Count";
    }


    ?>
        </table>
    </center>