<?php
session_start();
require('connection.php');

$student_id = $_POST['student_id'];
$fac_id = $_POST['fac_id'];
$dept_id = $_POST['dept_id'];
$major_id = $_POST['major_id'];
$student_name = $_POST['student_name'];
$class_of = $_POST['class_of'];
$status = $_POST['status'];

$query = mysqli_query($conn, "UPDATE students SET student_name='$student_name',class_of='$class_of',status='$status',major_id='$major_id',dept_id='$dept_id', fac_id='$fac_id' WHERE student_id='$student_id'");

if($query){
    $_SESSION['success'] = "Student berhasil diperbarui";
}
header("Location: ../students.php");
exit;
