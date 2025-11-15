<?php
require_once '../../includes/functions.php';
requireLogin();

if (!isset($_GET['kode'])) {
    header("Location: list.php");
    exit();
}

$kode = $_GET['kode'];

if (deleteTindakan($kode)) {
    $_SESSION['success'] = "Data tindakan berhasil dihapus";
} else {
    $_SESSION['error'] = "Gagal menghapus data tindakan";
}

header("Location: list.php");
exit();
?>