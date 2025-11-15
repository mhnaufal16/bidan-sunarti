<?php
require_once '../../includes/functions.php';
requireLogin();

// Get all obat for report
$obat = getObatReport();

// Handle search
if (isset($_GET['search'])) {
    $search = sanitizeInput($_GET['search']);
    $obat = array_filter($obat, function ($ob) use ($search) {
        return stripos($ob['kode_obat'], $search) !== false ||
            stripos($ob['nama_obat'], $search) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Obat - Bidan Sunarti</title>
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
            <h1>LAPORAN OBAT PASIEN IBU HAMIL</h1>

            <div class="no-print actions">
                <form method="GET" class="search-form">
                    <div class="form-group">
                        <input type="text" name="search" placeholder="Cari Kode/Nama Obat"
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
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($obat)): ?>
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data obat</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($obat as $index => $ob): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($ob['kode_obat']); ?></td>
                                <td><?php echo htmlspecialchars($ob['nama_obat']); ?></td>
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