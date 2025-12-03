<?php 
session_start();
require('connection.php');

$dept_name = $_POST['dept_name'];
$fac_id = $_POST['fac_id'];

$query = mysqli_query($conn, "INSERT INTO department (dept_name, fac_id) VALUES ('$dept_name', '$fac_id')");

if ($query) {
    $_SESSION['success'] = "Department berhasil ditambahkan!";
    header("Location: ../department.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
