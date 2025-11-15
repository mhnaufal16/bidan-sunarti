<?php
require_once '../../includes/functions.php';
requireLogin();

// Check for success message
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

// Get all tindakan
$tindakan = getAllTindakan();

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
    <title>Daftar Tindakan - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>DAFTAR TINDAKAN</h1>

            <?php if (isset($success)): ?>
                <div class="alert success"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="actions">
                <a href="input.php" class="btn">Tambah Tindakan</a>
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari Kode/Nama Tindakan">
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
                        <th>Kode Tindakan</th>
                        <th>Nama Tindakan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tindakan)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data tindakan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tindakan as $index => $tnd): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($tnd['kode_tindakan']); ?></td>
                                <td><?php echo htmlspecialchars($tnd['nama_tindakan']); ?></td>
                                <td>
                                    <a href="edit.php?kode=<?php echo $tnd['kode_tindakan']; ?>" class="btn small">Edit</a>
                                    <a href="delete.php?kode=<?php echo $tnd['kode_tindakan']; ?>" class="btn small secondary"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus tindakan ini?')">Hapus</a>
                                </td>
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