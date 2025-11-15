<?php
require_once '../../includes/functions.php';
requireLogin();

// Get all examinations for report
$examinations = getExaminationReport();

// Handle search
if (isset($_GET['search'])) {
    $search = sanitizeInput($_GET['search']);
    $examinations = array_filter($examinations, function ($exam) use ($search) {
        return stripos($exam['no_reg'], $search) !== false ||
            stripos($exam['nama'], $search) !== false;
    });
}

// Handle date filter
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = sanitizeInput($_GET['start_date']);
    $end_date = sanitizeInput($_GET['end_date']);

    if (!empty($start_date) && !empty($end_date)) {
        $examinations = array_filter($examinations, function ($exam) use ($start_date, $end_date) {
            $exam_date = $exam['tanggal'];
            return $exam_date >= $start_date && $exam_date <= $end_date;
        });
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pemeriksaan - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }

            body {
                font-size: 10px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>LAPORAN PEMERIKSAAN PASIEN IBU HAMIL</h1>

            <div class="no-print actions">
                <form method="GET" class="filter-form">
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" name="search" placeholder="Cari No. Reg/Nama"
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button type="submit" class="btn">Cari</button>
                            <a href="laporan.php" class="btn secondary">Reset</a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date"
                                value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai</label>
                            <input type="date" id="end_date" name="end_date"
                                value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">Filter</button>
                        </div>
                    </div>
                </form>
                <button onclick="window.print()" class="btn">Cetak Laporan</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Reg</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Tensi</th>
                        <th>BB</th>
                        <th>LILA</th>
                        <th>UK</th>
                        <th>DJJ</th>
                        <th>TFU</th>
                        <th>GPA</th>
                        <th>HPHT</th>
                        <th>HPL</th>
                        <th>Air Ketuban</th>
                        <th>Hasil Lab</th>
                        <th>Keluhan</th>
                        <th>Diagnosis</th>
                        <th>Tindakan</th>
                        <th>Obat</th>
                        <th>Hasil USG</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($examinations)): ?>
                        <tr>
                            <td colspan="20" class="text-center">Tidak ada data pemeriksaan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($examinations as $index => $exam): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($exam['no_reg']); ?></td>
                                <td><?php echo htmlspecialchars($exam['nama']); ?></td>
                                <td><?php echo formatDate($exam['tanggal']); ?></td>
                                <td><?php echo htmlspecialchars($exam['tensi'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['berat_badan'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['lila'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['uk'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['djj'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['tfu'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['gpa'] ?? '-'); ?></td>
                                <td><?php echo !empty($exam['hpht']) ? formatDate($exam['hpht']) : '-'; ?></td>
                                <td><?php echo !empty($exam['hpl']) ? formatDate($exam['hpl']) : '-'; ?></td>
                                <td><?php echo htmlspecialchars($exam['air_ketuban'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['hasil_lab'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['keluhan'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['nama_diagnosis'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['nama_tindakan'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['nama_obat'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($exam['hasil_usg'] ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>

        <?php include '../../includes/footer.php'; ?>
    </div>
</body>

</html>