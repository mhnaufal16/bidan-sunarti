<?php
require_once '../../includes/functions.php';
requireLogin();

if (!isset($_GET['kode'])) {
    header("Location: list.php");
    exit();
}

$kode = $_GET['kode'];

if (deleteObat($kode)) {
    $_SESSION['success'] = "Data obat berhasil dihapus";
} else {
    $_SESSION['error'] = "Gagal menghapus data obat";
}

header("Location: list.php");
exit();
?>