<?php
    include 'dp.php';
    //include 'scriptandlinks.php';

    session_start();
    $email = $_SESSION['email'];
    $sql = mysqli_query($con,"SELECT * from users where email='$email'");
    $row = mysqli_fetch_array($sql);
    $role = $row['role'];
    if($_SESSION['loggedin']!="true" || ($_SESSION['loggedin']!=true) || $role!='admission'){
        header("location: login.php");
        exit;
    }
?>
<?php
$sucessalert = false;
if(isset($_GET['id']))
{
    $id = $_GET['id'];
}
//include 'db.php';


if ($_SERVER['REQUEST_METHOD']=="POST"){
    $id = $_POST['id'];
    $countryID = $_POST['country'];
    $stateID = $_POST['state'];
    $cityID = $_POST['city'];

    $result = mysqli_query($con,"select name from countries where id='$countryID'");
    $row = mysqli_fetch_array($result);
    $countryname = $row['name'];

    $sresult = mysqli_query($con,"select state from states where s_id='$stateID'");
    $row1 = mysqli_fetch_array($sresult);
    $statename = $row1['state'];

    $cresult = mysqli_query($con,"select city from cities where c_id='$cityID'");
    $row2 = mysqli_fetch_array($cresult);
    $cityname = $row2['city'];

    $roll = $_POST['rollno'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $section = $_POST['section'];
    $sql1 = "UPDATE `users` SET `rollno`='$roll',`name`='$name', `class`='$class', `section`='$section', `country`='$countryname',`state`='$statename', `city`='$cityname' WHERE id='$id';";
    $result = mysqli_query($con,$sql1);
    $sucessalert = true;
            
    mysqli_close($con);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Update Record</title>
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
            if($sucessalert){
                echo '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong>Record updated.
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="close"></button>
            </div>';
            }
        ?>
        <div class="container">
            <h1 class="mt-5">Update Record</h1>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" id="createform">
                    <div class="form-group">
                        <p>Please fill this form and submit to update student record to the database.</p>
                        <input type="hidden" name="id" id="id" class="form-control mt-2" value="<?php echo $id;?>">
                    </div>
                    <div class="form-group">
                        <label for="rollno" class="mt-2">Roll No.</label>
                        <input type="number" name="rollno" id="rollno" class="form-control mt-2"  required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="mt-2">Name</label>
                        <input type="text" name="name" id="name" class="form-control mt-2" required>
                    </div>
                    <div class="form-group">
                        <label for="class" class="mt-2">Class</label>
                        <input type="number" name="class" id="class" class="form-control mt-2" value="<?php echo $class;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="section" class="mt-2">Section</label>
                        <select name="section" id="section" class="form-control mt-2" value="<?php echo $section;?>" required>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                        </select>

                    </div>
                <div class="form-group">
                    <label for="country" class="mt-2">Country</label>
                    <select type="text" name="country" id="country" class="form-control mt-2" value="<?php echo $countryID?>">
                    <option value="">Select Country</option>
                    <?php
                    //require_once 'db.php';
                    $result = mysqli_query($con,"SELECT * from countries");
                    while($row = mysqli_fetch_array($result)){
                        ?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="state" class="mt-2">State</label>
                    <select type="text" name="state" id="state" class="form-control mt-2" value="<?php echo $stateID; ?>"></select>
                </div>
                <div class="form-group">
                    <label for="city" class="mt-2">city</label>
                    <select type="text" name="city" id="city" class="form-control mt-2" value="<?php echo $cityID; ?>"></select>
                </div>
                
                <div class="mt-3 mb-3">
                    <button type="submit" class="btn btn-primary" id="btnadd">Submit</button>
                    <a href="manage_student.php" class="btn btn-secondary ml-2">Cancel</a>
                </div>
            </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

        <script>

            $(document).ready(function() {
            $('#country').on('change', function() {
            var country_id = this.value;
            $.ajax({
                url: "states-by-country.php",
                type: "POST",
                data: {
                    country_id: country_id
                },
                cache: false,
                success: function(result){
                    $("#state").html(result);
                    $('#city').html('<option value="">Select State First</option>'); 
                }
            });
            });    
            $('#state').on('change', function() {
            var state_id = this.value;
            $.ajax({
                url: "cities-by-state.php",
                type: "POST",
                data: {
                    state_id: state_id
                },
                cache: false,
                success: function(result){
            $("#city").html(result);
            }
            });
            });
            });
        </script>

    </body>
</html>