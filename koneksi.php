<?php
$host = "localhost";
$user = "root";      // sesuaikan dengan user mysql kamu
$pass = "";          // sesuaikan dengan password mysql kamu
$db   = "db_toko";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>