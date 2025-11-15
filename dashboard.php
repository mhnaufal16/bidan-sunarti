<?php

require_once 'includes/functions.php';
requireLogin();

$user = getUserById($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bidan Sunarti</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <?php include 'includes/header.php'; ?>

        <aside class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </aside>

        <main class="content">
            <h1>Dashboard</h1>

            <div class="stats-summary">
                <div class="stat-card">
                    <h3>Total Pasien</h3>
                    <p><?php echo count(getAllPatients()); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Pemeriksaan Hari Ini</h3>
                    <p>
                        <?php
                        $today = date('Y-m-d');
                        $result = $conn->query
                        ("SELECT COUNT(*) as count FROM pemeriksaan WHERE tanggal = '$today'");
                        $row = $result->fetch_assoc();
                        echo $row['count'];
                        ?>
                    </p>
                </div>
                <div class="stat-card">
                    <h3>Total Diagnosis</h3>
                    <p><?php echo count(getAllDiagnosis()); ?></p>
                </div>
            </div>

            <div class="dashboard-cards">
                <div class="card">
                    <h2>Input Pasien</h2>
                    <p>Kelola data pasien ibu hamil</p>
                    <a href="modules/pasien/input.php" class="btn">Buka</a>
                </div>

                <div class="card">
                    <h2>Pemeriksaan</h2>
                    <p>Input data pemeriksaan kehamilan</p>
                    <a href="modules/pemeriksaan/input.php" class="btn">Buka</a>
                </div>

                <div class="card">
                    <h2>Diagnosis</h2>
                    <p>Kelola data diagnosis</p>
                    <a href="modules/diagnosis/input.php" class="btn">Buka</a>
                </div>

                <div class="card">
                    <h2>Tindakan</h2>
                    <p>Kelola data tindakan medis</p>
                    <a href="modules/tindakan/input.php" class="btn">Buka</a>
                </div>

                <div class="card">
                    <h2>Obat</h2>
                    <p>Kelola data obat</p>
                    <a href="modules/obat/input.php" class="btn">Buka</a>
                </div>
            </div>

            <div class="recent-activity">
                <h2>Aktivitas Terakhir</h2>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pasien</th>
                            <th>Jenis Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Get recent examinations
                        $query = "SELECT pemeriksaan.tanggal, pasien.nama, 'Pemeriksaan' as jenis 
                                  FROM pemeriksaan 
                                  JOIN pendaftaran ON pemeriksaan.no_reg = pendaftaran.no_reg 
                                  JOIN pasien ON pendaftaran.nik = pasien.nik 
                                  ORDER BY pemeriksaan.tanggal DESC LIMIT 5";

                        $recent_examinations = $conn->query($query);

                        if ($recent_examinations && $recent_examinations->num_rows > 0) {
                            $counter = 1;
                            while ($row = $recent_examinations->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td><?php echo formatDate($row['tanggal']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($row['jenis']); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='4'>Tidak ada aktivitas terakhir</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php include 'includes/footer.php'; ?>
    </div>
</body>

</html>