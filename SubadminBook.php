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

        td {
            padding: 7px;
        }

        form {
            margin: 5px;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Issue Book's</span>
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
$count_query = "SELECT COUNT(*) as count FROM issue WHERE id like '%$search%' or BOOKNAME like '%$search%' or AUTHORNAME like '%$search%'";
$count_result = mysqli_query($con, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total = $count_row['count'];
$sql = "SELECT * FROM issue WHERE id like '%$search%' Or BOOKNAME like '%$search%' Or AUTHORNAME like '%$search%' ORDER BY id $sort_option";
$data = mysqli_query($con, $sql);
if ($total != 0) {
?>
    <center>
        <table border='3' cellspacing='7' width=46%>
            <tr>
                <th width=4%>S.No.</th>
                <th width=5%>Images</th>
                <th width=9%>Book Name</th>
                <th width=9%>Author Name</th>
                <th width=9%>Date</th>
                <th width=9%>Time</th>
                <th width=10%>Operation</th>
            </tr>
        <?php
        $a = 1;
        while ($result = mysqli_fetch_assoc($data)) {
            if ($result['Accept'] == '1') {
                if ($_SESSION['email'] == $result['email']) {
                    echo "<tr>
                    <td>$a</td>
                    <td><img src='" . $result['img_post'] . "'></td>
                    <td>" . $result['BOOKNAME'] . "</td>
                    <td>" . $result['AUTHORNAME'] . "</td>
                    <td>" . $result['Date'] . "</td>
                    <td>" . $result['Time'] . "</td>
                    <td>";
                    if ($result['MARK'] == 0 && $result['SUBMIT'] == 0) {
                        echo "<form method='POST' action='MARKSUB.php?id=$result[id]'>
                    <input type='submit' value='Mark' class='btn btn-success' name='mark'>
                    </form>
                    <form method='POST' action='SUBMITSUB.php?id=$result[id]'>
                    <input type='submit' value='Submit' class='btn btn-dark' name='submit'>
                    </form>";
                    } elseif ($result['MARK'] == 1 && $result['SUBMIT'] == 0) {
                        echo "<form method='POST' action='MARKSUB.php?id=$result[id]'>
                    <input type='submit' value='Marked as read' class='btn btn-success' name='mark' disabled>
                    </form>
                    <form method='POST' action='SUBMITSUB.php?id=$result[id]'>
                    <input type='submit' value='Submit' class='btn btn-dark' name='submit'>
                    </form>";
                    } elseif ($result['MARK'] == 0 && $result['SUBMIT'] == 1) {
                        echo "<form method='POST' action='MARKSUB.php?id=$result[id]'>
                    <input type='submit' value='Not Completed' class='btn btn-success' name='mark' disabled>
                    </form>
                    <form method='POST' action='SUBMITSUB.php?id=$result[id]'>
                    <input type='submit' value='Submitted' class='btn btn-dark' name='submit' disabled>
                    </form>";
                    } else {
                        echo "<form method='POST' action='MARKSUB.php?id=$result[id]'>
                    <input type='submit' value='Marked as read' class='btn btn-success' name='mark' disabled>
                    </form>
                    <form method='POST' action='SUBMITSUB.php?id=$result[id]'>
                    <input type='submit' value='Submitted' class='btn btn-dark' name='submit' disabled>
                    </form>";
                    }
                    echo "</td>
                </tr>";

                    $a++;
                }
            }
        }
    } else {
        echo "No Records Count";
    }
        ?>
        </table>
    </center>