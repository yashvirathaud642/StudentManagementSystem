<?php
    include 'dp.php';
   // include 'scriptandlinks.php';

    session_start();
    $email = $_SESSION['email'];
    $sql = mysqli_query($con,"SELECT * from users where email='$email'");
    $row = mysqli_fetch_array($sql);
    $role = $row['role'];
    $name = $row['name'];
    if($_SESSION['loggedin']!="true" || ($_SESSION['loggedin']!=true) || $role!='student'){
        header("location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome - <?php echo $_SESSION['email']; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
           </head>
    <body>
        <?php
        //include 'navbar.php';
        require 'dp.php';
        ?>
        <nav class="navbar navbar-light bg-dark p-3">
        <a class="navbar-brand text-white" href="./login.php">Student CRUD System </a>
        <div class="topnav-right">
    <a  class="text-white" href="profile.php" style="text-decoration: none;"><i class="fa-solid fa-user"></i>Profile</a>&nsbp;
    <a class="text-white" href="logout.php"  style="text-decoration: none;"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
  </div>
    </nav>
        <div class="container">
            <h1 class="mt-3 text-center">Students Detail.</h1>
        </div>
        <br><br>
        <div class="container">
            <?php
                $sql = "SELECT * from users WHERE email='$email' ORDER by id ASC;";
                $res = mysqli_query($con,$sql);
                if($res){
                    if(mysqli_num_rows($res)>0){
                        echo '<table class="table table-bordered table-striped" id="t1">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>ID</th>";
                                echo "<th>Email</th>";
                                echo "<th>Role</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = mysqli_fetch_array($res)){
                            echo "<tr>";
						        echo "<td>" . $row['id'] . "</td>";
						        echo "<td>" . $row['email'] . "</td>";
						        echo "<td>" . $row['role'] . "</td>";
						    echo "<tr>";
                        }
                    echo "</tbody>";                            
                    echo "</table>";
                    mysqli_free_result($res);
                    }
                    else{
                        echo '<div class="alert alert-danger">
                                No Record were Found.
                            </div>';
                    }
                }
                else{
                    echo 'OOPs! something went wrong. please try again later.';
                 }
            mysqli_close($con);
            ?>
        </div>
        <div class="container">
            <h2>Marksheet</h2>
        </div>
        <div class="container">
            <?php
            include 'dp.php';
                $sql = "SELECT * from student_marks WHERE name='$name';";
                $res = mysqli_query($con,$sql);
                if($res){
                    if(mysqli_num_rows($res)>0){
                        echo '<table class="table table-bordered table-striped" id="t2">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>Name</th>";
                                echo "<th>Physics</th>";
                                echo "<th>Chemistry</th>";
                                echo "<th>Math</th>";
                                echo "<th>Science</th>";
                                echo "<th>English</th>";
                                echo "<th>Hindi</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = mysqli_fetch_array($res)){
                            echo "<tr>";
						        echo "<td>" . $row['name'] . "</td>";
						        echo "<td>" . $row['physics'] . "</td>";
						        echo "<td>" . $row['chemistry'] . "</td>";
						        echo "<td>" . $row['math'] . "</td>";
						        echo "<td>" . $row['science'] . "</td>";
						        echo "<td>" . $row['english'] . "</td>";
						        echo "<td>" . $row['hindi'] . "</td>";
						    echo "<tr>";
                        }
                    echo "</tbody>";                            
                    echo "</table>";
                    mysqli_free_result($res);
                    }
                    else{
                        // echo '<div class="alert alert-danger">
                        //         No Record were Found.
                        //     </div>';
                    }
                }
                else{
                    echo 'OOPs! something went wrong. please try again later.';
                 }
            mysqli_close($con);
            ?>
        </div>

    </body>
</html>