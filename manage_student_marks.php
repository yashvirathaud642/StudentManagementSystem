<?php
    include 'dp.php';
   // include 'scriptandlinks.php';

    session_start();
    $email = $_SESSION['email'];
    $sql = mysqli_query($con,"SELECT * from users where email='$email'");
    $row = mysqli_fetch_array($sql);
    $role = $row['role'];
    if($_SESSION['loggedin']!="true" || ($_SESSION['loggedin']!=true) || $role!='teacher'){
        header("location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>admission staff</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

           </head>
    <body>
        <?php
        //require 'db.php';
        //include 'navbar.php';
        ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark p-3">
        <a class="navbar-brand text-white" href="login.php">Student Managment System </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="login nav-link text-white" href="teaher.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="register nav-link text-white" href="manage_user_ad.php">Manage Student Marks</a>
                </li>
                
            </ul>
        </div>
        </div>
        <div class="topnav-right">
            <a class="text-white" href="profile.php" style="text-decoration: none;"><i
                    class="fa-solid fa-user"></i>Profile</a>&nsbp;
            <a class="text-white" href="logout.php" style="text-decoration: none;"><i
                    class="fa-solid fa-right-from-bracket"></i>Logout</a>
        </div>
    </nav>
    

        <div class="container">
            <h1 class="mt-3 text-center">Update Students Mark.</h1>
        </div>
        <br><br>
        <div class="container">
            <?php
            $sql = "select class from classes where (physics='t1' or math='t1' or science='t1' or hindi='t1' or english='t1' or chemistry='t1')";
            $res = mysqli_query($con,$sql);
            $arr = array();
            while($row = mysqli_fetch_array($res)){
                array_push($arr,$row['class']);
            }
            $sql = "SELECT * from users where role='student' ORDER BY class ASC";
            $res = mysqli_query($con,$sql);
            
            if(mysqli_num_rows($res)>0){
                echo '<table class="table table-bordered table-striped">';
				echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Email</th>";
                echo "<th>Role</th>";
                echo "<th>Class</th>";
                echo "</tr>";
				echo "</thead>";
			    echo "<tbody>";
                while($row = mysqli_fetch_array($res)){
                    if(in_array($row["class"],$arr)){
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['role'] . "</td>";
                        echo "<td>" . $row['class'] . "</td>";
                        echo "<td>";	
                        echo '<a href="updatemarks.php?id='. $row['id'] .'" class="mr-3 btn btn-secondary" title="Update Details" data-toggle="tooltip">Update marks</a></td>';
                        echo "</tr>";
                    }
				}
			    echo "</tbody>";                            
                echo "</table>";
                mysqli_free_result($res);
            }
            
            
            ?>
    </div>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>	   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    
    <script>
        $(document).ready(function(){
            $('.add_btn_ajax').click(function(e){
                e.preventDefault();
                var addid = $(this).closest("tr").find('.add_id_value').val();
                swal.fire({
                    title: 'Are you Sure?',
                    text: 'Staff will be added to system.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#9A2124',
                    confirmButtonColor: '#34A853',
                    confirmButtonText: 'Yes, Add it!'
                }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            type: "POST",
                            url: 'add.php',
                            data:{
                                "add_btn_set": 1,
                                "add_id": addid,
                            },
                            success: function(response) {
                                console.log("here");
                                swal.fire(
                                    'Added!',
                                    'Your record has been added.',
                                    'success'
                                ).then((result)=>{
                                    window.location.reload();
                                });
                            } 
                        });
                    }
                })
                });
            });
        $(document).ready(function(){
        $('.delete_btn_ajax').click(function(e){
            e.preventDefault();
            var deleteid = $(this).closest("tr").find('.delete_id_value').val();
            swal.fire({
                title: 'Are you Sure?',
                text: 'You want be able to revert back.',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#9A2124',
                confirmButtonColor: '#34A853',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        type: "POST",
                        url: 'delete.php',
                        data:{
                            "delete_btn_set": 1,
                            "delete_id": deleteid,
                        },
                        success: function(response) {
                            console.log("here");
                            swal.fire(
                                'Deleted!',
                                'Your record has been removed.',
                                'success'
                            ).then((result)=>{
                                window.location.reload();
                            });
                        } 
                    });
                }
            })
            });
        });
        
    </script>
    </body>
</html>