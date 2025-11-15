<?php
require_once '../../includes/functions.php';
requireLogin();

// Get all registrations for dropdown
$registrations = getAllRegistrations();
$diagnosis = getAllDiagnosis();
$tindakan = getAllTindakan();
$obat = getAllObat();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'no_reg' => sanitizeInput($_POST['no_reg']),
        'tanggal' => sanitizeInput($_POST['tanggal']),
        'tensi' => sanitizeInput($_POST['tensi']),
        'berat_badan' => floatval($_POST['berat_badan']),
        'lila' => floatval($_POST['lila']),
        'uk' => intval($_POST['uk']),
        'djj' => intval($_POST['djj']),
        'tfu' => intval($_POST['tfu']),
        'gpa' => sanitizeInput($_POST['gpa']),
        'hpht' => sanitizeInput($_POST['hpht']),
        'hpl' => sanitizeInput($_POST['hpl']),
        'air_ketuban' => sanitizeInput($_POST['air_ketuban']),
        'hasil_lab' => sanitizeInput($_POST['hasil_lab']),
        'keluhan' => sanitizeInput($_POST['keluhan']),
        'kode_diagnosis' => sanitizeInput($_POST['kode_diagnosis']),
        'kode_tindakan' => sanitizeInput($_POST['kode_tindakan']),
        'kode_obat' => sanitizeInput($_POST['kode_obat']),
        'hasil_usg' => sanitizeInput($_POST['hasil_usg'])
    ];

    if (addPemeriksaan($data)) {
        $_SESSION['success'] = "Data pemeriksaan berhasil disimpan";
        header("Location: list.php");
        exit();
    } else {
        $error = "Gagal menyimpan data pemeriksaan";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pemeriksaan - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>FORM PEMERIKSAAN</h1>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="examination-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="no_reg">No Reg</label>
                        <select id="no_reg" name="no_reg" required>
                            <option value="">Pilih No. Registrasi</option>
                            <?php foreach ($registrations as $reg): ?>
                                <option value="<?php echo htmlspecialchars($reg['no_reg']); ?>">
                                    <?php echo htmlspecialchars($reg['no_reg']); ?> -
                                    <?php echo htmlspecialchars($reg['nama']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal Pemeriksaan</label>
                        <input type="date" id="tanggal" name="tanggal" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tensi">Tensi</label>
                        <input type="text" id="tensi" name="tensi" maxlength="6" placeholder="Contoh: 120/80">
                    </div>

                    <div class="form-group">
                        <label for="berat_badan">Berat Badan (kg)</label>
                        <input type="number" id="berat_badan" name="berat_badan" step="0.1" min="0">
                    </div>

                    <div class="form-group">
                        <label for="lila">LILA (cm)</label>
                        <input type="number" id="lila" name="lila" step="0.1" min="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="uk">Usia Kehamilan (minggu)</label>
                        <input type="number" id="uk" name="uk" min="0" max="50">
                    </div>

                    <div class="form-group">
                        <label for="djj">DJJ (denyut/menit)</label>
                        <input type="number" id="djj" name="djj" min="0">
                    </div>

                    <div class="form-group">
                        <label for="tfu">TFU (cm)</label>
                        <input type="number" id="tfu" name="tfu" min="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="gpa">GPA</label>
                        <input type="text" id="gpa" name="gpa" maxlength="3" placeholder="Contoh: G1P0A0">
                    </div>

                    <div class="form-group">
                        <label for="hpht">HPHT</label>
                        <input type="date" id="hpht" name="hpht">
                    </div>

                    <div class="form-group">
                        <label for="hpl">HPL</label>
                        <input type="date" id="hpl" name="hpl">
                    </div>
                </div>

                <div class="form-group">
                    <label for="air_ketuban">Air Ketuban</label>
                    <input type="text" id="air_ketuban" name="air_ketuban" maxlength="4">
                </div>

                <div class="form-group">
                    <label for="hasil_lab">Hasil Lab</label>
                    <textarea id="hasil_lab" name="hasil_lab"></textarea>
                </div>

                <div class="form-group">
                    <label for="keluhan">Keluhan</label>
                    <textarea id="keluhan" name="keluhan"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kode_diagnosis">Diagnosis</label>
                        <select id="kode_diagnosis" name="kode_diagnosis">
                            <option value="">Pilih Diagnosis</option>
                            <?php foreach ($diagnosis as $diag): ?>
                                <option value="<?php echo htmlspecialchars($diag['kode_diagnosis']); ?>">
                                    <?php echo htmlspecialchars($diag['kode_diagnosis']); ?> -
                                    <?php echo htmlspecialchars($diag['nama_diagnosis']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kode_tindakan">Tindakan</label>
                        <select id="kode_tindakan" name="kode_tindakan">
                            <option value="">Pilih Tindakan</option>
                            <?php foreach ($tindakan as $tnd): ?>
                                <option value="<?php echo htmlspecialchars($tnd['kode_tindakan']); ?>">
                                    <?php echo htmlspecialchars($tnd['kode_tindakan']); ?> -
                                    <?php echo htmlspecialchars($tnd['nama_tindakan']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kode_obat">Obat</label>
                        <select id="kode_obat" name="kode_obat">
                            <option value="">Pilih Obat</option>
                            <?php foreach ($obat as $ob): ?>
                                <option value="<?php echo htmlspecialchars($ob['kode_obat']); ?>">
                                    <?php echo htmlspecialchars($ob['kode_obat']); ?> -
                                    <?php echo htmlspecialchars($ob['nama_obat']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="hasil_usg">Hasil USG</label>
                    <textarea id="hasil_usg" name="hasil_usg"></textarea>
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
    <script>
        document.getElementById('tanggal').valueAsDate = new Date();

        // Calculate HPL from HPHT (Naegele's rule)
        document.getElementById('hpht').addEventListener('change', function () {
            const hpht = new Date(this.value);
            if (!isNaN(hpht.getTime())) {
                const hpl = new Date(hpht);
                hpl.setDate(hpl.getDate() + 7);
                hpl.setMonth(hpl.getMonth() + 9);

                const hplFormatted = hpl.toISOString().split('T')[0];
                document.getElementById('hpl').value = hplFormatted;
            }
        });
    </script>
</body>

</html>