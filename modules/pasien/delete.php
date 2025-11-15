<?php
require_once '../../includes/functions.php';
requireLogin();

if (!isset($_GET['nik'])) {
    header("Location: list.php");
    exit();
}

$nik = $_GET['nik'];

if (deletePatient($nik)) {
    $_SESSION['success'] = "Data pasien berhasil dihapus";
} else {
    $_SESSION['error'] = "Gagal menghapus data pasien";
}

header("Location: list.php");
exit();
?>