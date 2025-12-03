<?php 
session_start();
require('connection.php');

$dept_id = $_POST['dept_id'];
$dept_name = $_POST['dept_name'];
$fac_id = $_POST['fac_id'];

$query = mysqli_query($conn, "UPDATE department SET dept_name = '$dept_name', fac_id = '$fac_id' WHERE dept_id = '$dept_id'");

if ($query) {
    $_SESSION['success'] = "Department berhasil diupdate!";
    header("Location: ../department.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
