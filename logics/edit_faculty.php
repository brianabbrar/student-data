<?php 
session_start();
require('connection.php');

$fac_id = $_POST['fac_id'];
$fac_name = $_POST['fac_name'];

$query = mysqli_query($conn, "UPDATE faculty SET fac_name = '$fac_name' WHERE fac_id = '$fac_id'");

if ($query) {
    $_SESSION['success'] = "Fakultas Berhasil di update!";
    header("Location: ../faculty.php");
} else {
    echo "Error: " . mysqli_error($conn);
}


?>