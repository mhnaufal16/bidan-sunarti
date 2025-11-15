<?php
require_once '../../includes/functions.php';
requireLogin();

// Get all diagnosis for report
$diagnosis = getDiagnosisReport();

// Handle search
if (isset($_GET['search'])) {
    $search = sanitizeInput($_GET['search']);
    $diagnosis = array_filter($diagnosis, function ($diag) use ($search) {
        return stripos($diag['kode_diagnosis'], $search) !== false ||
            stripos($diag['nama_diagnosis'], $search) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Diagnosis - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }

            body {
                font-size: 12px;
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
            <h1>LAPORAN DIAGNOSA PASIEN IBU HAMIL</h1>

            <div class="no-print actions">
                <form method="GET" class="search-form">
                    <div class="form-group">
                        <input type="text" name="search" placeholder="Cari Kode/Nama Diagnosis"
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button type="submit" class="btn">Cari</button>
                        <a href="laporan.php" class="btn secondary">Reset</a>
                    </div>
                </form>
                <button onclick="window.print()" class="btn">Cetak Laporan</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Diagnosa</th>
                        <th>Nama Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($diagnosis)): ?>
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data diagnosis</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($diagnosis as $index => $diag): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($diag['kode_diagnosis']); ?></td>
                                <td><?php echo htmlspecialchars($diag['nama_diagnosis']); ?></td>
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