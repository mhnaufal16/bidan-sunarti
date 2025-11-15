<?php
require_once '../../includes/functions.php';
requireLogin();

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$id = intval($_GET['id']);

if (deletePemeriksaan($id)) {
    $_SESSION['success'] = "Data pemeriksaan berhasil dihapus";
} else {
    $_SESSION['error'] = "Gagal menghapus data pemeriksaan";
}

header("Location: list.php");
exit();
?>