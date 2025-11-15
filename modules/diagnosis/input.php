<?php
require_once '../../includes/functions.php';
requireLogin();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'kode_diagnosis' => sanitizeInput($_POST['kode_diagnosis']),
        'nama_diagnosis' => sanitizeInput($_POST['nama_diagnosis'])
    ];

    if (addDiagnosis($data)) {
        $_SESSION['success'] = "Data diagnosis berhasil disimpan";
        header("Location: list.php");
        exit();
    } else {
        $error = "Gagal menyimpan data diagnosis. Mungkin kode diagnosis sudah ada.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Diagnosis - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>DATA DIAGNOSIS</h1>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="diagnosis-form">
                <div class="form-group">
                    <label for="kode_diagnosis">Kode Diagnosis</label>
                    <input type="text" id="kode_diagnosis" name="kode_diagnosis" maxlength="5" required>
                </div>

                <div class="form-group">
                    <label for="nama_diagnosis">Nama Diagnosis</label>
                    <input type="text" id="nama_diagnosis" name="nama_diagnosis" maxlength="20" required>
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