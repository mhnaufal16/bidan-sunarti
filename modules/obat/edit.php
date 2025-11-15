<?php
require_once '../../includes/functions.php';
requireLogin();

if (!isset($_GET['kode'])) {
    header("Location: list.php");
    exit();
}

$kode = $_GET['kode'];
$obat = getObatByKode($kode);

if (!$obat) {
    header("Location: list.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'kode_obat' => $kode,
        'nama_obat' => sanitizeInput($_POST['nama_obat'])
    ];

    if (updateObat($data)) {
        $_SESSION['success'] = "Data obat berhasil diperbarui";
        header("Location: list.php");
        exit();
    } else {
        $error = "Gagal memperbarui data obat";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Obat - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>EDIT OBAT</h1>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="obat-form">
                <div class="form-group">
                    <label for="kode_obat">Kode Obat</label>
                    <input type="text" id="kode_obat" name="kode_obat"
                        value="<?php echo htmlspecialchars($obat['kode_obat']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" id="nama_obat" name="nama_obat"
                        value="<?php echo htmlspecialchars($obat['nama_obat']); ?>" maxlength="20" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Simpan Perubahan</button>
                    <a href="list.php" class="btn secondary">Batal</a>
                </div>
            </form>
        </main>

        <?php include '../../includes/footer.php'; ?>
    </div>
</body>

</html>