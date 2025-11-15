<?php
require_once '../../includes/functions.php';
requireLogin();

if (!isset($_GET['kode'])) {
    header("Location: list.php");
    exit();
}

$kode = $_GET['kode'];
$diagnosis = getDiagnosisByKode($kode);

if (!$diagnosis) {
    header("Location: list.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'kode_diagnosis' => $kode,
        'nama_diagnosis' => sanitizeInput($_POST['nama_diagnosis'])
    ];

    if (updateDiagnosis($data)) {
        $_SESSION['success'] = "Data diagnosis berhasil diperbarui";
        header("Location: list.php");
        exit();
    } else {
        $error = "Gagal memperbarui data diagnosis";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Diagnosis - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>EDIT DIAGNOSIS</h1>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="diagnosis-form">
                <div class="form-group">
                    <label for="kode_diagnosis">Kode Diagnosis</label>
                    <input type="text" id="kode_diagnosis" name="kode_diagnosis"
                        value="<?php echo htmlspecialchars($diagnosis['kode_diagnosis']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_diagnosis">Nama Diagnosis</label>
                    <input type="text" id="nama_diagnosis" name="nama_diagnosis"
                        value="<?php echo htmlspecialchars($diagnosis['nama_diagnosis']); ?>" maxlength="20" required>
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