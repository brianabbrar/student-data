<?php
$servername = "localhos";  
$username   = "root";       
$password   = "";           
$database   = "db_siswa";


$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>


