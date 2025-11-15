<?php
require_once '../../includes/functions.php';
requireLogin();

if (!isset($_GET['kode'])) {
    header("Location: list.php");
    exit();
}

$kode = $_GET['kode'];
$tindakan = getTindakanByKode($kode);

if (!$tindakan) {
    header("Location: list.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'kode_tindakan' => $kode,
        'nama_tindakan' => sanitizeInput($_POST['nama_tindakan'])
    ];

    if (updateTindakan($data)) {
        $_SESSION['success'] = "Data tindakan berhasil diperbarui";
        header("Location: list.php");
        exit();
    } else {
        $error = "Gagal memperbarui data tindakan";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tindakan - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>EDIT TINDAKAN</h1>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="tindakan-form">
                <div class="form-group">
                    <label for="kode_tindakan">Kode Tindakan</label>
                    <input type="text" id="kode_tindakan" name="kode_tindakan"
                        value="<?php echo htmlspecialchars($tindakan['kode_tindakan']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_tindakan">Nama Tindakan</label>
                    <input type="text" id="nama_tindakan" name="nama_tindakan"
                        value="<?php echo htmlspecialchars($tindakan['nama_tindakan']); ?>" maxlength="20" required>
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