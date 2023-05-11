<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>User Details</title>
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
        table{
            margin-top: 100px;
        }

      
    </style>
    
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">User Details</span>
            <a href="ADDMORE.php"><button type="button" class="btn btn-outline-success">Add User's</button></a>
        </div>
    </nav>
</body>

</html>

<?php
    include('Attach.php');
    $sort_option = "";
    $numberPages = 5;
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
    $count_query = "SELECT COUNT(*) as count FROM admin";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total = $count_row['count'];

    $num = ceil($total / $numberPages);

    $startinglimit = ($page - 1) * $numberPages;

    $sql = "SELECT * FROM admin WHERE (user_type = 'user' OR user_type = 'sub_admin') AND (id LIKE '%$search%' OR name LIKE '%$search%' OR email LIKE '%$search%') ORDER BY name $sort_option LIMIT $startinglimit, $numberPages";

    
    $data = mysqli_query($con, $sql);
if ($total != 0) {
    ?>
        <center>
            <table border='3' cellspacing='7' width=53%>
                <tr>
                    <th width=5%>S.No.</th>
                    <th width=10%>User Name</th>
                    <th width=10%>User email</th>
                    <th width=10%>User type</th>
                    <th width=18%>Function</th>
                </tr>
            <?php
    $a = 1;
    while ($result = mysqli_fetch_assoc($data)) {
        echo "<tr>
                    <td>$a</td>
                    <td>" . $result['name'] . "</td>
                    <td>" . $result['email'] . "</td>
                    <td>" . $result['user_type'] . "</td>

                    <td>
                    <a href='Uptodate.php?id=$result[id]'><input type='submit' value='Update' class='btn btn-success'></a>

                    <a href='DELET.php?id=$result[id]'><input type='submit' value='Delete' class='btn btn-danger' onclick='return checkdelete()'></a>
                    </td>
                </tr>";
        $a++;
    }
}
     else {
        echo "No Records Count";
    }
    
    ?>
            </table>
            <?php
            if ($page > 1) {
                echo '<button class="btn btn-dark mx-1 my-3"><a href="Admin.php?page=' . ($page - 1) . '&sort_alphabet=' . $sort_option . '" class="text-light">Previous</a></button>';
            }
            for ($btn = 1; $btn <= $num; $btn++) {
                echo '<button class="btn btn-dark mx-1 my-3"><a href="Admin.php?page=' . $btn . '&sort_alphabet=' . $sort_option . '" class="text-light">' . $btn . '</a></button>';
            }
            if ($page < $num) {
                echo '<button class="btn btn-dark mx-1 my-3"><a href="Admin.php?page=' . ($page + 1) . '&sort_alphabet=' . $sort_option . '" class="text-light">Next</a></button>';
            }
          ?>
          
        </center>