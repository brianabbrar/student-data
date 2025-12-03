<?php
session_start();

require('connection.php');

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];

$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");

if (mysqli_num_rows($check) > 0) {
    $_SESSION['failed'] = "Email sudah terdaftar!";
    header('Location: ../register.php');
    exit();
} else {
    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Simpan data user baru
    $query = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$hashed')";
    $result = mysqli_query($conn, $query);

    if ($result) {
                // Redirect ke halaman index.php setelah berhasil
                $_SESSION['success'] = "Registrasi berhasil! Silakan login sekarang.";
                header("Location: ../index.php");
                exit(); // penting: hentikan eksekusi setelah redirect
            } else {
                echo "<script>alert('Registrasi gagal!');</script>";
            }
}
