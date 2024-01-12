<?php
    include 'dp.php';
    session_start();
    $email = $_SESSION['email'];
    $sql = mysqli_query($con,"SELECT * from users where email='$email'");
    $row = mysqli_fetch_array($sql);
    $role = $row['role'];
    if($_SESSION['loggedin']!="true" || ($_SESSION['loggedin']!=true) || $role!='admin'){
        header("location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admission</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php
    include 'navbar.php';
    //require 'dp.php';
    ?>
    <div class="container">
        <h1 class="mt-3 text-center">Manage Admission staff</h1>

    </div>
    <br><br>
    <div class="container">
        <?php
        $sql = "SELECT * from users where role='admission'";
        $res = mysqli_query($con, $sql);
        if ($res) {
            if (mysqli_num_rows($res) > 0) {
                echo '<table class="table table-bordered table-striped">';
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Email</th>";
                echo "<th>Role</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['role'] . "</td>";
                    echo "<td>";
                    echo '<a href="view.php?id=' . $row['id'] . '" class="mr-3 btn btn-light" title="Open Details" data-toggle="tooltip"><span class="fa fa-eye"></span></a> &nbsp;';
                    echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3 btn btn-light" title="Update Details" data-toggle="tooltip"><span class="fa fa-pencil"></span></a> &nbsp;';
                    echo '<a href="javascript:void(0)" title="Delete Student" class="delete_btn_ajax btn btn-light" data-toggle="tooltip"><span class="fa fa-trash"></span></a> &nbsp;';
                    echo '<input type="hidden" class="delete_id_value" value=' . $row["id"] . '>
            </td>';
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                mysqli_free_result($res);
            } else {
                echo '<div class="alert alert-danger">
                                No Record were Found.
                            </div>';
            }
        } else {
            echo 'OOPs! something went wrong. please try again later.';
        }
        mysqli_close($con);
        ?>
    </div>
    <script>
        $(document).ready(function () {
            $('.delete_btn_ajax').click(function (e) {
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
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: 'delete.php',
                            data: {
                                "delete_btn_set": 1,
                                "delete_id": deleteid,
                            },
                            success: function (response) {
                                console.log("here");
                                swal.fire(
                                    'Deleted!',
                                    'Your reocrd has been deleted.',
                                    'success'
                                ).then((result) => {
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