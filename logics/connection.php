<?php
$servername = "sql100.infinityfree.com";  
$username   = "if0_40593565";       
$password   = "5LctqAZ3gxpY";           
$database   = "if0_40593565_student";


$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?> 


