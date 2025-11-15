<?php
require_once '../../includes/functions.php';
requireLogin();

// Check for success message
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

// Get all examinations
$examinations = getAllPemeriksaan();

// Handle search
if (isset($_GET['search'])) {
    $search = sanitizeInput($_GET['search']);
    $examinations = array_filter($examinations, function ($exam) use ($search) {
        return stripos($exam['no_reg'], $search) !== false ||
            stripos($exam['nama'], $search) !== false ||
            stripos($exam['nik'], $search) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemeriksaan - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>DAFTAR PEMERIKSAAN</h1>

            <?php if (isset($success)): ?>
                <div class="alert success"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="actions">
                <a href="input.php" class="btn">Tambah Pemeriksaan</a>
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
                        <th>Nama Pasien</th>
                        <th>Tanggal</th>
                        <th>UK</th>
                        <th>DJJ</th>
                        <th>Diagnosis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($examinations)): ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pemeriksaan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($examinations as $index => $exam): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($exam['no_reg']); ?></td>
                                <td><?php echo htmlspecialchars($exam['nama']); ?></td>
                                <td><?php echo formatDate($exam['tanggal']); ?></td>
                                <td><?php echo htmlspecialchars($exam['uk']); ?> minggu</td>
                                <td><?php echo htmlspecialchars($exam['djj']); ?> dpm</td>
                                <td><?php echo htmlspecialchars($exam['nama_diagnosis'] ?? '-'); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $exam['id']; ?>" class="btn small">Edit</a>
                                    <a href="delete.php?id=<?php echo $exam['id']; ?>" class="btn small secondary"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pemeriksaan ini?')">Hapus</a>
                                    <a href="detail.php?id=<?php echo $exam['id']; ?>" class="btn small">Detail</a>
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