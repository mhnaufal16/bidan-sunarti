<?php
require_once '../../includes/functions.php';
requireLogin();

// Get all tindakan for report
$tindakan = getTindakanReport();

// Handle search
if (isset($_GET['search'])) {
    $search = sanitizeInput($_GET['search']);
    $tindakan = array_filter($tindakan, function ($tnd) use ($search) {
        return stripos($tnd['kode_tindakan'], $search) !== false ||
            stripos($tnd['nama_tindakan'], $search) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tindakan - Bidan Sunarti</title>
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
            <h1>LAPORAN TINDAKAN PASIEN IBU HAMIL</h1>

            <div class="no-print actions">
                <form method="GET" class="search-form">
                    <div class="form-group">
                        <input type="text" name="search" placeholder="Cari Kode/Nama Tindakan"
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
                        <th>Kode Tindakan</th>
                        <th>Nama Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tindakan)): ?>
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data tindakan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tindakan as $index => $tnd): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($tnd['kode_tindakan']); ?></td>
                                <td><?php echo htmlspecialchars($tnd['nama_tindakan']); ?></td>
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