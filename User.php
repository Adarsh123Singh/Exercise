<?php
session_start();
// Check if user is authenticated
if (!isset($_SESSION['user_name']) && ($_SESSION['email']) && ($_SESSION['user_type'])) {
    header("location: LOGIN.php");
    exit();
}
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
            <span class="navbar-brand mb-0 h1">Book Details</span>
            <a href="UserBook.php" button type="button" class="btn btn-outline-info">Info</button></a>
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
                    <option value="" hidden>--Select Option</option>
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
include('edit.php');
$sort_option = "";
$numberPages = 3;
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

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$count_query = "SELECT COUNT(*) as count FROM edit WHERE id like '%$search%' or BOOKNAME like '%$search%' or AUTHERNAME like '%$search%'";
$count_result = mysqli_query($con, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total = $count_row['count'];

$num = ceil($total / $numberPages);

$startinglimit = ($page - 1) * $numberPages;
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $result = "SELECT * FROM admin WHERE id=$id";
    $data = mysqli_query($con, $result);
}

$sql = "SELECT * FROM edit WHERE id like '%$search%' Or BOOKNAME like '%$search%' Or AUTHERNAME like '%$search%' ORDER BY BOOKNAME $sort_option LIMIT $startinglimit,$numberPages ";
$data = mysqli_query($con, $sql);
if ($total != 0) {
?>
    <center>
        <table border='3' cellspacing='7' width=82%>
            <tr>
                <th width=4% height=2%>S.No.</th>
                <th width=5% height=2%>Images</th>
                <th width=9% height=2%>Book Name</th>
                <th width=9% height=2%>Book Title</th>
                <th width=9% height=2%>Author Name</th>
                <th width=9% height=2%>No. of Books</th>
                <th width=22% height=2%>Description</th>
                <th width=15% height=2%>Operation</th>
            </tr>
        <?php
        $a = ($page - 1) * $numberPages + 1;
        while ($result = mysqli_fetch_assoc($data)) {
            echo "<tr>
                    <td>$a</td>
                    <td><img src='" . $result['img_post'] . "'></td>
                    <td>" . $result['BOOKNAME'] . "</td>
                    <td>" . $result['BOOKTITLE'] . "</td>
                    <td>" . $result['AUTHERNAME'] . "</td>
                    <td>" . $result['NUMBER'] . "</td>
                    <td>" . substr($result['DESCRIPTION'], 0, 100) . "...</td>

                    <td><a href='viewuser.php?id=$result[id]'><input type='submit' value='View' class='btn btn-info'></a>";
                    if($result['issueuser'] == '0'){
                        echo "<a href='issueuser.php?id=$result[id]'><input type='submit' value='Book Issue' class='btn btn-dark'></a>";
                    }else{
                        echo "<a href=''><input type='submit' value='Book Issued' class='btn btn-dark' disabled></a>";
                    }
                    
                    echo "</td>
                </tr>";
            $a++;
        }
    } else {
        echo "No Records Count";
    }
        ?>
        </table>
        <?php
if ($page > 1) {
    echo '<button class="btn btn-dark mx-1 my-3"><a href="User.php?page=' . ($page - 1) . '&sort_alphabet=' . $sort_option . '&search=' . $search . '" class="text-light">Previous</a></button>';
}

// show the first page link
if ($page > 2) {
    echo '<button class="btn btn-dark mx-1 my-3"><a href="User.php?page=1&sort_alphabet=' . $sort_option . '&search=' . $search . '" class="text-light">1</a></button>';
}

// show dots if there are more than 3 pages
if ($page > 3) {
    echo '<button class="btn btn-dark mx-1 my-3" disabled>...</button>';
}

// show two links before the current page
for ($btn = max(1, $page - 1); $btn < $page; $btn++) {
    echo '<button class="btn btn-dark mx-1 my-3"><a href="User.php?page=' . $btn . '&sort_alphabet=' . $sort_option . '&search=' . $search . '" class="text-light">' . $btn . '</a></button>';
}

// show the current page link
echo '<button class="btn btn-primary mx-1 my-3">' . $page . '</button>';

// show two links after the current page
for ($btn = $page + 1; $btn <= min($page + 1, $num); $btn++) {
    echo '<button class="btn btn-dark mx-1 my-3"><a href="User.php?page=' . $btn . '&sort_alphabet=' . $sort_option . '&search=' . $search . '" class="text-light">' . $btn . '</a></button>';
}

// show dots if there are more than 3 pages
if ($page < $num - 2) {
    echo '<button class="btn btn-dark mx-1 my-3" disabled>...</button>';
}

// show the last page link
if ($page < $num - 1) {
    echo '<button class="btn btn-dark mx-1 my-3"><a href="User.php?page=' . $num . '&sort_alphabet=' . $sort_option . '&search=' . $search . '" class="text-light">' . $num . '</a></button>';
}

if ($page < $num) {
    echo '<button class="btn btn-dark mx-1 my-3"><a href="User.php?page=' . ($page + 1) . '&sort_alphabet=' . $sort_option . '&search=' . $search . '" class="text-light">Next</a></button>';
}
?>
    </center>