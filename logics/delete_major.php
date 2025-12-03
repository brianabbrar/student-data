<?php
session_start();
require('connection.php');

$major_id = $_GET['major_id'];

// Matikan exception sementara agar tidak fatal error
mysqli_report(MYSQLI_REPORT_OFF);

// Hapus major
$query = mysqli_query($conn, "DELETE FROM major WHERE major_id = '$major_id'");

if ($query) {
    $_SESSION['success'] = "Major berhasil dihapus!";
} else {
    $_SESSION['failed'] = "Tidak bisa dihapus, masih ada mahasiswa yang terkait dengan jurusan ini!";
}

header("Location: ../major.php");
exit;
?>
