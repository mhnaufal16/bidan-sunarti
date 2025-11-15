<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bidan_sunarti";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Opsi 1: Jika menggunakan server lokal biasa
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST']);
?>