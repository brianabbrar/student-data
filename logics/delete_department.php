<?php 
session_start();
require('connection.php');

$dept_id = $_GET['dept_id'];

// Matikan exception sementara agar tidak fatal jika gagal
mysqli_report(MYSQLI_REPORT_OFF);

// Hapus department
$query = mysqli_query($conn, "DELETE FROM department WHERE dept_id = '$dept_id'");

if ($query) {
    $_SESSION['success'] = "Department beserta jurusan terkait berhasil dihapus!";
    header("Location: ../department.php");
    exit;
} else {
    $_SESSION['failed'] = "Tidak bisa di hapus, masih ada student, departement, major di fakultas ini";
    header("Location: ../department.php");
    exit;
}
?>
