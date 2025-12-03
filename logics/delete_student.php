<?php
session_start();
require('connection.php');

$student_id = $_GET['student_id'];

$query = mysqli_query($conn, "DELETE FROM students WHERE student_id='$student_id'");

if($query){
    $_SESSION['success'] = "Student berhasil dihapus";
}
header("Location: ../students.php");
exit;


