<?php 
session_start();
require('connection.php');

$major_name = $_POST['major_name'];
$dept_id = $_POST['dept_id'];
$fac_id = $_POST['fac_id'];

$query = mysqli_query($conn, "INSERT INTO major (major_name, dept_id) VALUES ('$major_name', '$dept_id')");

if ($query) {
    $_SESSION['success'] = "Major berhasil ditambahkan!";
    header("Location: ../major.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
