<?php
session_start();
require('connection.php');

$faculty_name = $_POST['faculty_name'];

$query = mysqli_query($conn, ("INSERT INTO faculty (fac_name) VALUES ('$faculty_name')"));

if($query){
    $_SESSION['success'] = "berhasil Menambahkan Data Fakultas Baru";
    header("Location: ../faculty.php");
    exit();
}else{
    $_SESSION['failed'] = "ada kesalahan!";
    header("Location: ../faculty.php");
    exit();
}

