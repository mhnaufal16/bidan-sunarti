<?php
require_once '../../includes/functions.php';
requireLogin();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nik' => sanitizeInput($_POST['nik']),
        'nama' => sanitizeInput($_POST['nama']),
        'tempat_lahir' => sanitizeInput($_POST['tempat_lahir']),
        'tanggal_lahir' => sanitizeInput($_POST['tanggal_lahir']),
        'agama' => sanitizeInput($_POST['agama']),
        'umur' => intval($_POST['umur']),
        'alamat' => sanitizeInput($_POST['alamat']),
        'pekerjaan' => sanitizeInput($_POST['pekerjaan']),
        'pendidikan' => sanitizeInput($_POST['pendidikan']),
        'status_pasien' => sanitizeInput($_POST['status_pasien']),
        'nama_suami' => sanitizeInput($_POST['nama_suami']),
        'no_hp' => sanitizeInput($_POST['no_hp'])
    ];

    if (addPatient($data)) {
        $_SESSION['success'] = "Data pasien berhasil disimpan";
        header("Location: list.php");
        exit();
    } else {
        $error = "Gagal menyimpan data pasien. Mungkin NIK sudah terdaftar.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Pasien - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>INPUT DATA PASIEN IBU HAMIL</h1>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="patient-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" id="nik" name="nik" maxlength="16" required>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Pasien</label>
                        <input type="text" id="nama" name="nama" maxlength="30" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" maxlength="20">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <input type="text" id="agama" name="agama" maxlength="6">
                    </div>

                    <div class="form-group">
                        <label for="umur">Umur</label>
                        <input type="number" id="umur" name="umur" min="0" max="120">
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" maxlength="40"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" id="pekerjaan" name="pekerjaan" maxlength="15">
                    </div>

                    <div class="form-group">
                        <label for="pendidikan">Pendidikan</label>
                        <input type="text" id="pendidikan" name="pendidikan" maxlength="15">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="status_pasien">Status Pasien</label>
                        <input type="text" id="status_pasien" name="status_pasien" maxlength="15">
                    </div>

                    <div class="form-group">
                        <label for="nama_suami">Nama Suami</label>
                        <input type="text" id="nama_suami" name="nama_suami" maxlength="25">
                    </div>
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" id="no_hp" name="no_hp" maxlength="13">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Simpan</button>
                    <button type="reset" class="btn secondary">Reset</button>
                    <a href="list.php" class="btn">Lihat Data</a>
                </div>
            </form>
        </main>

        <?php include '../../includes/footer.php'; ?>
    </div>
</body>

</html>