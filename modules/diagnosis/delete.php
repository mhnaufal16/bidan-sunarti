<?php
require_once '../../includes/functions.php';
requireLogin();

if (!isset($_GET['kode'])) {
    header("Location: list.php");
    exit();
}

$kode = $_GET['kode'];

if (deleteDiagnosis($kode)) {
    $_SESSION['success'] = "Data diagnosis berhasil dihapus";
} else {
    $_SESSION['error'] = "Gagal menghapus data diagnosis";
}

header("Location: list.php");
exit();
?>