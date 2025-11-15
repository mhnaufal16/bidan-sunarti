<?php

require_once '../../includes/functions.php';
requireLogin();

if (!isset($_GET['no_reg'])) {
    header("Location: list.php");
    exit();
}

$no_reg = $_GET['no_reg'];
$registration = getRegistrationByNoReg($no_reg);

if (!$registration) {
    header("Location: list.php");
    exit();
}

// Get all patients for dropdown
$patients = getAllPatients();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'no_reg' => $no_reg,
        'nik' => sanitizeInput($_POST['nik']),
        'tanggal_masuk' => sanitizeInput($_POST['tanggal_masuk'])
    ];

    if (updateRegistration($data)) {
        $_SESSION['success'] = "Data pendaftaran berhasil diperbarui";
        header("Location: list.php");
        exit();
    } else {
        $error = "Gagal memperbarui data pendaftaran";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pendaftaran - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>EDIT PENDAFTARAN PASIEN</h1>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="registration-form">
                <div class="form-group">
                    <label for="no_reg">No Reg</label>
                    <input type="text" id="no_reg" name="no_reg"
                        value="<?php echo htmlspecialchars($registration['no_reg']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nik">Nama Pasien</label>
                    <select id="nik" name="nik" required>
                        <option value="">Pilih Pasien</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo htmlspecialchars($patient['nik']); ?>" <?php echo $patient['nik'] == $registration['nik'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($patient['nik']); ?> -
                                <?php echo htmlspecialchars($patient['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                        value="<?php echo htmlspecialchars($registration['tanggal_masuk']); ?>" required>
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