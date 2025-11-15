<?php
require_once '../../includes/functions.php';
requireLogin();

if (!isset($_GET['no_reg'])) {
    header("Location: list.php");
    exit();
}

$no_reg = $_GET['no_reg'];

if (deleteRegistration($no_reg)) {
    $_SESSION['success'] = "Data pendaftaran berhasil dihapus";
} else {
    $_SESSION['error'] = "Gagal menghapus data pendaftaran";
}

header("Location: list.php");
exit();
?>