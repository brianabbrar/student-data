<?php 
session_start();
require('connection.php');

$major_id = $_POST['major_id'];
$major_name = $_POST['major_name'];
$dept_id = $_POST['dept_id'];
$fac_id = $_POST['fac_id'];

$query = mysqli_query($conn, "UPDATE major SET major_name = '$major_name', dept_id = '$dept_id' WHERE major_id = '$major_id'");

if ($query) {
    $_SESSION['success'] = "Major berhasil diupdate!";
    header("Location: ../major.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
