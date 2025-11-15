<?php
require_once '../../includes/functions.php';
requireLogin();

// Check for success message
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

// Get all diagnosis
$diagnosis = getAllDiagnosis();

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
    <title>Daftar Diagnosis - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>DAFTAR DIAGNOSIS</h1>

            <?php if (isset($success)): ?>
                <div class="alert success"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="actions">
                <a href="input.php" class="btn">Tambah Diagnosis</a>
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari Kode/Nama Diagnosis">
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
                        <th>Kode Diagnosis</th>
                        <th>Nama Diagnosis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($diagnosis)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data diagnosis</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($diagnosis as $index => $diag): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($diag['kode_diagnosis']); ?></td>
                                <td><?php echo htmlspecialchars($diag['nama_diagnosis']); ?></td>
                                <td>
                                    <a href="edit.php?kode=<?php echo $diag['kode_diagnosis']; ?>" class="btn small">Edit</a>
                                    <a href="delete.php?kode=<?php echo $diag['kode_diagnosis']; ?>" class="btn small secondary"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus diagnosis ini?')">Hapus</a>
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