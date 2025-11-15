<?php
require_once '../../includes/functions.php';
requireLogin();

// Get all patients for dropdown
$patients = getAllPatients();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'no_reg' => sanitizeInput($_POST['no_reg']),
        'nik' => sanitizeInput($_POST['nik']),
        'tanggal_masuk' => sanitizeInput($_POST['tanggal_masuk']),
        'keluhan' => sanitizeInput($_POST['keluhan']) // Tambah keluhan
    ];

    if (addRegistration($data)) {
        $_SESSION['success'] = "Data pendaftaran berhasil disimpan";
        header("Location: list.php");
        exit();
    } else {
        $error = "Gagal menyimpan data pendaftaran. Mungkin No. Reg sudah terdaftar.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pendaftaran - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>PENDAFTARAN PASIEN IBU HAMIL</h1>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="registration-form">
                <div class="form-group">
                    <label for="no_reg">No Reg</label>
                    <input type="text" id="no_reg" name="no_reg" maxlength="8" required>
                </div>

                <div class="form-group">
                    <label for="nik">Nama Pasien</label>
                    <select id="nik" name="nik" required>
                        <option value="">Pilih Pasien</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo htmlspecialchars($patient['nik']); ?>">
                                <?php echo htmlspecialchars($patient['nik']); ?> -
                                <?php echo htmlspecialchars($patient['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" required>
                </div>

                <div class="form-group">
                    <label for="keluhan">Keluhan</label>
                    <input type="text" id="keluhan" name="keluhan" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Simpan</button>
                    <a href="list.php" class="btn secondary">Batal</a>
                </div>
            </form>
        </main>

        <?php include '../../includes/footer.php'; ?>
    </div>
    <script>
        document.getElementById('tanggal_masuk').valueAsDate = new Date();
    </script>
</body>

</html>