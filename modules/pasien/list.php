<?php
require_once '../../includes/functions.php';
requireLogin();

// Check for success message
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

// Get all patients
$patients = getAllPatients();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pasien - Bidan Sunarti</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php include '../../includes/header.php'; ?>

        <aside class="sidebar">
            <?php include '../../includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>DAFTAR PASIEN IBU HAMIL</h1>

            <?php if (isset($success)): ?>
                <div class="alert success"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="actions">
                <a href="input.php" class="btn">Tambah Pasien</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>TTL</th>
                        <th>Umur</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($patients)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pasien</td>
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
                                <td><?php echo htmlspecialchars($patient['alamat']); ?></td>
                                <td>
                                    <a href="edit.php?nik=<?php echo $patient['nik']; ?>" class="btn small">Edit</a>
                                    <a href="delete.php?nik=<?php echo $patient['nik']; ?>" class="btn small secondary"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pasien ini?')">Hapus</a>
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