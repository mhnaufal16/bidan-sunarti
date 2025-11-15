<?php
require_once '../../includes/functions.php';
requireLogin();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'kode_tindakan' => sanitizeInput($_POST['kode_tindakan']),
        'nama_tindakan' => sanitizeInput($_POST['nama_tindakan'])
    ];

    if (addTindakan($data)) {
        $_SESSION['success'] = "Data tindakan berhasil disimpan";
        header("Location: list.php");
        exit();
    } else {
        $error = "Gagal menyimpan data tindakan. Mungkin kode tindakan sudah ada.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Tindakan - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>DATA TINDAKAN</h1>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="tindakan-form">
                <div class="form-group">
                    <label for="kode_tindakan">Kode Tindakan</label>
                    <input type="text" id="kode_tindakan" name="kode_tindakan" maxlength="8" required>
                </div>

                <div class="form-group">
                    <label for="nama_tindakan">Nama Tindakan</label>
                    <input type="text" id="nama_tindakan" name="nama_tindakan" maxlength="20" required>
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