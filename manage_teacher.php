<?php
    include 'dp.php';
    //include 'scriptandlinks.php';

    session_start();
    $email = $_SESSION['email'];
    $sql = mysqli_query($con,"SELECT * from users where email='$email'");
    $row = mysqli_fetch_array($sql);
    $role = $row['role'];
    if($_SESSION['loggedin']!="true" || ($_SESSION['loggedin']!=true) || $role!='admin'){
        header("loaction: login.php");
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
        include 'navbar.php';
        ?>
        <div class="container">
            <h1 class="mt-3 text-center">Manage Teachers</h1>
        </div>
        <br><br>
        <div class="container">
            <?php
            $sql = "SELECT * from users where role='teacher'";
            $res = mysqli_query($con,$sql);
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
                    echo "<td>";	
                        echo '<a href="viewteacher.php?id='. $row['id'] .'" class="mr-3 btn btn-success" title="Open Details" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                        echo '<a href="updateteacher.php?id='. $row['id'] .'" class="mr-3 btn btn-success" title="Update Details" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
						echo '<a href="javascript:void(0)" title="Delete Student" class="delete_btn_ajax btn btn-success" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
						echo '<input type="hidden" class="delete_id_value" value='.$row["id"].'>';
                        echo '</td>';
				    echo "</tr>";
				}
			    echo "</tbody>";                            
                echo "</table>";
                mysqli_free_result($res);
            }
            
            
            ?>
    </div>
    <div class="container mt-5">
        <a href="assign.php" class="ms-3 btn btn-success" title="Assign" data-toggle="tooltip">Assign Class and Subject</a>
    </div>

    <div class="container mt-5">
        <h5>Teachers assigned based on class and subjects.</h5>
            <?php
            $sql = "SELECT * from classes ";
            $res = mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                echo '<table class="table table-bordered table-striped" id="t2">';
				echo "<thead>";
                echo "<tr>";
                echo "<th>CLASS</th>";
                echo "<th>MATH</th>";
                echo "<th>SCIENCE</th>";
                echo "<th>HINDI</th>";
                echo "<th>ENGLISH</th>";
                echo "<th>PHYSICS</th>";
                echo "<th>CHEMISTRY</th>";
                echo "</tr>";
				echo "</thead>";
			    echo "<tbody>";
                while($row = mysqli_fetch_array($res)){
                    echo "<tr>";
                    echo "<td>" . $row['class'] . "</td>";
                    echo "<td>" . $row['math'] . "</td>";
                    echo "<td>" . $row['science'] . "</td>";
                    echo "<td>" . $row['hindi'] . "</td>";
                    echo "<td>" . $row['english'] . "</td>";
                    echo "<td>" . $row['physics'] . "</td>";
                    echo "<td>" . $row['chemistry'] . "</td>";
				    echo "</tr>";
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