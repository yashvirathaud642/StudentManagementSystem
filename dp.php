<?php
$con = mysqli_connect("localhost", "root", "", "schools");
echo "server is connected";

if (!$con) {
  echo "Failed connection " . mysqli_connect_error();
}
?>