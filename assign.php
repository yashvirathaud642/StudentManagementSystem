<?php
    $successalert = false;
    include 'dp.php';
    //include 'scriptandlinks.php';

    session_start();
    $email = $_SESSION['email'];
    $sql = mysqli_query($con,"SELECT * from users where email='$email'");
    $row = mysqli_fetch_array($sql);
    $role = $row['role'];
    if($_SESSION['loggedin']!="true" || ($_SESSION['loggedin']!=true) || $role!='admin'){
        header("location: login.php");
        exit;
    }


if ($_SERVER['REQUEST_METHOD']=="POST"){
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $name = $_POST['name'];
    $sql = "UPDATE classes SET $subject='$name' WHERE class='$class'";
    $res = mysqli_query($con,$sql);
    $successalert = true;
            
    mysqli_close($con);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Assign</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/jqajax.js"></script>
        <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
        <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

    
    </head>
    <body>
        <?php
            include 'navbar.php';
            if($successalert){
                echo '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong>Assigned successfully.
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="close"></button>
            </div>';
            }
        ?>
        <div class="container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" id="createform">
                <div class="form-group">
                    <p>Please fill this form and submit to assign class and subject.</p>
                    <label for="class">Class</label>
                    <input type="number" name="class" id="class" class="form-control mt-2" value="<?php echo $class;?>">
                </div>
                <div class="form-group">
                    <label for="name" class="mt-2">Teacher</label>
                    <select type="text" name="name" id="name" class="form-control mt-2" value="<?php echo $name?>">
                    <option value="">Select Teacher</option>
                    <?php
                    require_once 'dp.php';
                    $result = mysqli_query($con,"SELECT * from users WHERE role='teacher'");
                    while($row = mysqli_fetch_array($result)){
                        ?>
                        <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
                        <?php
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subject" class="mt-2">Subject</label>
                    <select name="subject" id="subject" class="form-control mt-2" value="<?php echo $subject;?>" required>
                        <option value="physics">Physics</option>
                        <option value="chemistry">Chemistry</option>
                        <option value="math">Math</option>
                        <option value="science">Science</option>
                        <option value="english">English</option>
                        <option value="hindi">Hindi</option>
                    </select>
                </div>
                <div class="mt-3 mb-3">
                    <button type="submit" class="btn btn-primary" id="btnadd">Submit</button>
                    <a href="manage_teacher.php" class="btn btn-secondary ml-2">Cancel</a>
                </div>
            </form>
        </div>                

    </body>
</html>