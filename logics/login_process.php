<?php
session_start();
require('connection.php');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// (Opsional) kecilkan risiko injection:
$email = mysqli_real_escape_string($conn, trim($email));

$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");

if ($check && mysqli_num_rows($check) > 0) {
    $result = mysqli_fetch_assoc($check);

    // jangan buat hash baru — verifikasi password dengan password_verify
    if (password_verify($password, $result['password'])) {
        // set session jika perlu
        $_SESSION['user_id']  = $result['user_id'];
        $_SESSION['fullname'] = $result['fullname'];
        $_SESSION['email']    = $result['email'];
        $_SESSION['role']     = $result['role'];

        header('Location: ../dashboard.php');
        exit();
    } else {
        $_SESSION['failed'] = "Email/Password anda Salah!";
        header('Location: ../index.php');
        exit();
    }
} else {
    $_SESSION['failed'] = "Email/Password anda Salah!";
    header('Location: ../index.php');
    exit();
}
