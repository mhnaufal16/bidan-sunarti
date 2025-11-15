<?php
require_once '../../includes/functions.php';
requireLogin();

// Check for success message
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

// Get all registrations
$registrations = getAllRegistrations();

// Handle search
if (isset($_GET['search'])) {
    $search = sanitizeInput($_GET['search']);
    $registrations = array_filter($registrations, function ($reg) use ($search) {
        return stripos($reg['no_reg'], $search) !== false ||
            stripos($reg['nik'], $search) !== false ||
            stripos($reg['nama'], $search) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pendaftaran - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>DAFTAR PENDAFTARAN PASIEN</h1>

            <?php if (isset($success)): ?>
                <div class="alert success"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="actions">
                <a href="input.php" class="btn">Tambah Pendaftaran</a>
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari No. Reg/NIK/Nama">
                    <button type="submit" class="btn">Cari</button>
                    <?php if (isset($_GET['search'])): ?>
                        <a href="list.php" class="btn secondary">Reset</a>
                    <?php endif; ?>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Reg</th>
                        <th>NIK</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Masuk</th>
                        <th>Keluhan</th>
                  
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registrations)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pendaftaran</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($registrations as $index => $reg): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($reg['no_reg']); ?></td>
                                <td><?php echo htmlspecialchars($reg['nik']); ?></td>
                                <td><?php echo htmlspecialchars($reg['nama']); ?></td>
                                <td><?php echo formatDate($reg['tanggal_masuk']); ?></td>
                                <td><?php echo htmlspecialchars($reg['keluhan']); ?></td>
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