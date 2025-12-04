<?php
$servername = "mysql";  
$username   = "root";       
$password   = "password";           
$database   = "myapp";


$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>

