<?php
require_once '../../includes/functions.php';
requireLogin();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'kode_obat' => sanitizeInput($_POST['kode_obat']),
        'nama_obat' => sanitizeInput($_POST['nama_obat'])
    ];

    if (addObat($data)) {
        $_SESSION['success'] = "Data obat berhasil disimpan";
        header("Location: list.php");
        exit();
    } else {
        $error = "Gagal menyimpan data obat. Mungkin kode obat sudah ada.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Obat - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>DATA OBAT</h1>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="obat-form">
                <div class="form-group">
                    <label for="kode_obat">Kode Obat</label>
                    <input type="text" id="kode_obat" name="kode_obat" maxlength="5" required>
                </div>

                <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" id="nama_obat" name="nama_obat" maxlength="20" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Simpan</button>
                    <a href="list.php" class="btn secondary">Batal</a>
                </div>
            </form>
        </main>

        <?php include '../../includes/footer.php'; ?>
    </div>
</body>

</html>