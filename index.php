<?php
$login = false;
$showerror = false;
$usererror = false;
$_SESSION['loggedin'] = false;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Student Mangement System </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-light bg-dark p-3">
        <a class="navbar-brand text-white" href="./login.php">Student CRUD System </a>
    </nav>
    <div class="container p-3">
        <h1 style="text-align:center;"> Welcome to the student CRUD system </h1>
        <table class="table table-bordered table-light p-3">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Register User</th>
                    <th scope="col">New User</th>
                </tr>
            </thead>
            <th>
                <div class="p-3">
                    <a href="./login.php"><button type="button" class="btn btn-outline-primary">LogIn</button></a>
                </div>
            </th>
            <th>
                <div class="p-3">
                    <a href="./register.php"><button type="button" class="btn btn-outline-primary">SignUp</button></a>
            </th>
    </div>
    </th>
    </tr>
    </table>
    </div>
    </div>
</body>

</html>