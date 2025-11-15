<?php
require_once '../../includes/functions.php';
requireLogin();

// Get all patients for report
$patients = getPatientReport();

// Handle search
if (isset($_GET['search'])) {
    $search = sanitizeInput($_GET['search']);
    $patients = array_filter($patients, function ($patient) use ($search) {
        return stripos($patient['nama'], $search) !== false ||
            stripos($patient['nik'], $search) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pasien - Bidan Sunarti</title>
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
            <h1>LAPORAN DATA PASIEN IBU HAMIL</h1>

            <div class="no-print actions">
                <form method="GET" class="search-form">
                    <div class="form-group">
                        <input type="text" name="search" placeholder="Cari NIK atau Nama"
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
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>TTL</th>
                        <th>Umur</th>
                        <th>Agama</th>
                        <th>Alamat</th>
                        <th>Pekerjaan</th>
                        <th>Pendidikan</th>
                        <th>Status Pasien</th>
                        <th>Nama Suami</th>
                        <th>No HP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($patients)): ?>
                        <tr>
                            <td colspan="12" class="text-center">Tidak ada data pasien</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($patients as $index => $patient): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($patient['nik']); ?></td>
                                <td><?php echo htmlspecialchars($patient['nama']); ?></td>
                                <td><?php echo htmlspecialchars($patient['tempat_lahir']); ?>,
                                    <?php echo formatDate($patient['tanggal_lahir']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($patient['umur']); ?></td>
                                <td><?php echo htmlspecialchars($patient['agama']); ?></td>
                                <td><?php echo htmlspecialchars($patient['alamat']); ?></td>
                                <td><?php echo htmlspecialchars($patient['pekerjaan']); ?></td>
                                <td><?php echo htmlspecialchars($patient['pendidikan']); ?></td>
                                <td><?php echo htmlspecialchars($patient['status_pasien']); ?></td>
                                <td><?php echo htmlspecialchars($patient['nama_suami']); ?></td>
                                <td><?php echo htmlspecialchars($patient['no_hp']); ?></td>
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