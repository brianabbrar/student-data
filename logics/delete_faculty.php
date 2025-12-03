<?php
session_start();
require('connection.php');

$fac_id = $_GET['id'];

// Matikan exception sementara agar tidak fatal jika gagal
mysqli_report(MYSQLI_REPORT_OFF);

// Hapus faculty
$query = mysqli_query($conn, "DELETE FROM faculty WHERE fac_id = '$fac_id'");

if ($query) {
    $_SESSION['success'] = "Fakultas berhasil dihapus!";
} else {
    $_SESSION['failed'] = "Tidak bisa dihapus, masih ada department atau major yang terkait!";
}

header("Location: ../faculty.php");
exit;
?>
