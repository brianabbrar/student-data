<?php
session_start();
require('connection.php');

$fac_id = $_POST['fac_id'];
$dept_id = $_POST['dept_id'];
$major_id = $_POST['major_id'];
$student_name = $_POST['student_name'];
$class_of = $_POST['class_of'];
$status = $_POST['status'];

$query = mysqli_query($conn, "INSERT INTO students (student_name, class_of, status, major_id, dept_id, fac_id) 
VALUES ('$student_name', '$class_of', '$status', '$major_id', '$dept_id', '$fac_id')");

if($query){
    $_SESSION['success'] = "Student berhasil ditambahkan";
}
header("Location: ../students.php");
exit;
