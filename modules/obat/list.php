<?php
require_once '../../includes/functions.php';
requireLogin();

// Check for success message
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

// Get all obat
$obat = getAllObat();

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
    <title>Daftar Obat - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>DAFTAR OBAT</h1>

            <?php if (isset($success)): ?>
                <div class="alert success"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="actions">
                <a href="input.php" class="btn">Tambah Obat</a>
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari Kode/Nama Obat">
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
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($obat)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data obat</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($obat as $index => $ob): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($ob['kode_obat']); ?></td>
                                <td><?php echo htmlspecialchars($ob['nama_obat']); ?></td>
                                <td>
                                    <a href="edit.php?kode=<?php echo $ob['kode_obat']; ?>" class="btn small">Edit</a>
                                    <a href="delete.php?kode=<?php echo $ob['kode_obat']; ?>" class="btn small secondary"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">Hapus</a>
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