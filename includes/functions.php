<?php
require_once __DIR__ . '/../config.php';

// USER FUNCTIONS
// Tambahkan di bagian atas setelah require_once 'config.php'

// Start session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function redirectIfLoggedIn()
{
    // Cek apakah user sudah login
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        // Redirect ke halaman dashboard
        header('Location: dashboard.php');
        exit();
    }
}

function redirectIfNotLoggedIn()
{
    // Cek apakah user belum login
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        // Redirect ke halaman login
        header('Location: login.php');
        exit();
    }
}

function loginUser($user_id)
{
    // Set session untuk user yang login
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_logged_in'] = true;

    // Regenerate session ID untuk mencegah session fixation
    session_regenerate_id(true);
}

function logoutUser()
{
    // Hapus semua data session
    $_SESSION = array();

    // Hapus session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Hancurkan session
    session_destroy();

    // Redirect ke halaman selamat datang
    header('Location: index.php');
    exit();
}


function isLoggedIn()
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function getCurrentUserId()
{
    return $_SESSION['user_id'] ?? null;
}
// USER FUNCTIONS
function authenticateUser($username, $password)
{
    global $conn;

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return $user['id'];
        }
    }

    return false;
}

function registerUser($username, $password)
{
    global $conn;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    return $stmt->execute();
}

function getUserById($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// PATIENT FUNCTIONS
function addPatient($data)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO pasien (nik, nama, tempat_lahir, tanggal_lahir, agama, umur, alamat, pekerjaan, pendidikan, status_pasien, nama_suami, no_hp) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssissssss",
        $data['nik'],
        $data['nama'],
        $data['tempat_lahir'],
        $data['tanggal_lahir'],
        $data['agama'],
        $data['umur'],
        $data['alamat'],
        $data['pekerjaan'],
        $data['pendidikan'],
        $data['status_pasien'],
        $data['nama_suami'],
        $data['no_hp']
    );

    return $stmt->execute();
}

function updatePatient($data)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE pasien SET nama = ?, tempat_lahir = ?, tanggal_lahir = ?, agama = ?, umur = ?, alamat = ?, pekerjaan = ?, pendidikan = ?, status_pasien = ?, nama_suami = ?, no_hp = ? WHERE nik = ?");
    $stmt->bind_param(
        "ssssisssssss",
        $data['nama'],
        $data['tempat_lahir'],
        $data['tanggal_lahir'],
        $data['agama'],
        $data['umur'],
        $data['alamat'],
        $data['pekerjaan'],
        $data['pendidikan'],
        $data['status_pasien'],
        $data['nama_suami'],
        $data['no_hp'],
        $data['nik']
    );

    return $stmt->execute();
}

function getPatientByNik($nik)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM pasien WHERE nik = ?");
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getAllPatients()
{
    global $conn;
    $result = $conn->query("SELECT * FROM pasien ORDER BY nama");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function deletePatient($nik)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM pasien WHERE nik = ?");
    $stmt->bind_param("s", $nik);
    return $stmt->execute();
}

// REGISTRATION FUNCTIONS
function addRegistration($data)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO pendaftaran (no_reg, nik, tanggal_masuk, keluhan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $data['no_reg'], $data['nik'], $data['tanggal_masuk'], $data['keluhan']);

    return $stmt->execute();
}

function updateRegistration($data)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE pendaftaran SET nik = ?, tanggal_masuk = ? WHERE no_reg = ?");
    $stmt->bind_param("sss", $data['nik'], $data['tanggal_masuk'], $data['no_reg']);

    return $stmt->execute();
}

function getRegistrationByNoReg($no_reg)
{
    global $conn;
    $stmt = $conn->prepare("SELECT p.*, ps.nama FROM pendaftaran p JOIN pasien ps ON p.nik = ps.nik WHERE p.no_reg = ?");
    $stmt->bind_param("s", $no_reg);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getAllRegistrations()
{
    global $conn;
    $result = $conn->query("SELECT p.*, ps.nama FROM pendaftaran p JOIN pasien ps ON p.nik = ps.nik ORDER BY p.tanggal_masuk DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function deleteRegistration($no_reg)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM pendaftaran WHERE no_reg = ?");
    $stmt->bind_param("s", $no_reg);
    return $stmt->execute();
}

// DIAGNOSIS FUNCTIONS
function addDiagnosis($data)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO diagnosis (kode_diagnosis, nama_diagnosis) VALUES (?, ?)");
    $stmt->bind_param("ss", $data['kode_diagnosis'], $data['nama_diagnosis']);

    return $stmt->execute();
}

function updateDiagnosis($data)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE diagnosis SET nama_diagnosis = ? WHERE kode_diagnosis = ?");
    $stmt->bind_param("ss", $data['nama_diagnosis'], $data['kode_diagnosis']);

    return $stmt->execute();
}

function getDiagnosisByKode($kode)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM diagnosis WHERE kode_diagnosis = ?");
    $stmt->bind_param("s", $kode);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getAllDiagnosis()
{
    global $conn;
    $result = $conn->query("SELECT * FROM diagnosis ORDER BY nama_diagnosis");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function deleteDiagnosis($kode)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM diagnosis WHERE kode_diagnosis = ?");
    $stmt->bind_param("s", $kode);
    return $stmt->execute();
}

// TINDAKAN FUNCTIONS
function addTindakan($data)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO tindakan (kode_tindakan, nama_tindakan) VALUES (?, ?)");
    $stmt->bind_param("ss", $data['kode_tindakan'], $data['nama_tindakan']);

    return $stmt->execute();
}

function updateTindakan($data)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE tindakan SET nama_tindakan = ? WHERE kode_tindakan = ?");
    $stmt->bind_param("ss", $data['nama_tindakan'], $data['kode_tindakan']);

    return $stmt->execute();
}

function getTindakanByKode($kode)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM tindakan WHERE kode_tindakan = ?");
    $stmt->bind_param("s", $kode);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getAllTindakan()
{
    global $conn;
    $result = $conn->query("SELECT * FROM tindakan ORDER BY nama_tindakan");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function deleteTindakan($kode)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM tindakan WHERE kode_tindakan = ?");
    $stmt->bind_param("s", $kode);
    return $stmt->execute();
}

// OBAT FUNCTIONS
function addObat($data)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO obat (kode_obat, nama_obat) VALUES (?, ?)");
    $stmt->bind_param("ss", $data['kode_obat'], $data['nama_obat']);

    return $stmt->execute();
}

function updateObat($data)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE obat SET nama_obat = ? WHERE kode_obat = ?");
    $stmt->bind_param("ss", $data['nama_obat'], $data['kode_obat']);

    return $stmt->execute();
}

function getObatByKode($kode)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM obat WHERE kode_obat = ?");
    $stmt->bind_param("s", $kode);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getAllObat()
{
    global $conn;
    $result = $conn->query("SELECT * FROM obat ORDER BY nama_obat");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function deleteObat($kode)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM obat WHERE kode_obat = ?");
    $stmt->bind_param("s", $kode);
    return $stmt->execute();
}

// EXAMINATION FUNCTIONS
function addPemeriksaan($data)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO pemeriksaan (no_reg, tanggal, tensi, berat_badan, lila, uk, djj, tfu, gpa, hpht, hpl, air_ketuban, hasil_lab, keluhan) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssddiiissssss",
        $data['no_reg'],
        $data['tanggal'],
        $data['tensi'],
        $data['berat_badan'],
        $data['lila'],
        $data['uk'],
        $data['djj'],
        $data['tfu'],
        $data['gpa'],
        $data['hpht'],
        $data['hpl'],
        $data['air_ketuban'],
        $data['hasil_lab'],
        $data['keluhan']
    );

    if ($stmt->execute()) {
        $pemeriksaan_id = $stmt->insert_id;

        // Add examination details if any
        if (!empty($data['kode_diagnosis']) || !empty($data['kode_tindakan']) || !empty($data['kode_obat']) || !empty($data['hasil_usg'])) {
            $stmt_detail = $conn->prepare("INSERT INTO pemeriksaan_detail (pemeriksaan_id, kode_diagnosis, kode_tindakan, kode_obat, hasil_usg) 
                                         VALUES (?, ?, ?, ?, ?)");
            $stmt_detail->bind_param("issss", $pemeriksaan_id, $data['kode_diagnosis'], $data['kode_tindakan'], $data['kode_obat'], $data['hasil_usg']);
            $stmt_detail->execute();
        }

        return $pemeriksaan_id;
    }

    return false;
}

function updatePemeriksaan($data)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE pemeriksaan SET tanggal = ?, tensi = ?, berat_badan = ?, lila = ?, uk = ?, djj = ?, tfu = ?, gpa = ?, hpht = ?, hpl = ?, air_ketuban = ?, hasil_lab = ?, keluhan = ? WHERE id = ?");
    $stmt->bind_param(
        "ssddiiisssssi",
        $data['tanggal'],
        $data['tensi'],
        $data['berat_badan'],
        $data['lila'],
        $data['uk'],
        $data['djj'],
        $data['tfu'],
        $data['gpa'],
        $data['hpht'],
        $data['hpl'],
        $data['air_ketuban'],
        $data['hasil_lab'],
        $data['keluhan'],
        $data['id']
    );

    if ($stmt->execute()) {
        // Update examination details
        $stmt_detail = $conn->prepare("UPDATE pemeriksaan_detail SET kode_diagnosis = ?, kode_tindakan = ?, kode_obat = ?, hasil_usg = ? WHERE pemeriksaan_id = ?");
        $stmt_detail->bind_param("ssssi", $data['kode_diagnosis'], $data['kode_tindakan'], $data['kode_obat'], $data['hasil_usg'], $data['id']);
        $stmt_detail->execute();

        return true;
    }

    return false;
}

function getPemeriksaanById($id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT p.*, pd.kode_diagnosis, pd.kode_tindakan, pd.kode_obat, pd.hasil_usg 
                           FROM pemeriksaan p 
                           LEFT JOIN pemeriksaan_detail pd ON p.id = pd.pemeriksaan_id 
                           WHERE p.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getAllPemeriksaan()
{
    global $conn;
    $result = $conn->query("SELECT p.*, ps.nama, pd.kode_diagnosis, pd.kode_tindakan, pd.kode_obat 
                           FROM pemeriksaan p 
                           JOIN pendaftaran pg ON p.no_reg = pg.no_reg 
                           JOIN pasien ps ON pg.nik = ps.nik 
                           LEFT JOIN pemeriksaan_detail pd ON p.id = pd.pemeriksaan_id 
                           ORDER BY p.tanggal DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function deletePemeriksaan($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM pemeriksaan WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// REPORT FUNCTIONS
function getPatientReport()
{
    global $conn;
    $result = $conn->query("SELECT * FROM pasien ORDER BY nama");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getRegistrationReport()
{
    global $conn;
    $result = $conn->query("SELECT p.*, ps.nama FROM pendaftaran p JOIN pasien ps ON p.nik = ps.nik ORDER BY p.tanggal_masuk DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getExaminationReport()
{
    global $conn;
    $result = $conn->query("SELECT p.*, ps.nama, dg.nama_diagnosis, tn.nama_tindakan, ob.nama_obat 
                           FROM pemeriksaan p 
                           JOIN pendaftaran pg ON p.no_reg = pg.no_reg 
                           JOIN pasien ps ON pg.nik = ps.nik 
                           LEFT JOIN pemeriksaan_detail pd ON p.id = pd.pemeriksaan_id 
                           LEFT JOIN diagnosis dg ON pd.kode_diagnosis = dg.kode_diagnosis 
                           LEFT JOIN tindakan tn ON pd.kode_tindakan = tn.kode_tindakan 
                           LEFT JOIN obat ob ON pd.kode_obat = ob.kode_obat 
                           LEFT JOIN keluhan kl ON p.keluhan = kl.kode_keluhan
                           ORDER BY p.tanggal DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getDiagnosisReport()
{
    global $conn;
    $result = $conn->query("SELECT * FROM diagnosis ORDER BY nama_diagnosis");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getTindakanReport()
{
    global $conn;
    $result = $conn->query("SELECT * FROM tindakan ORDER BY nama_tindakan");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getObatReport()
{
    global $conn;
    $result = $conn->query("SELECT * FROM obat ORDER BY nama_obat");
    return $result->fetch_all(MYSQLI_ASSOC);
}


// UTILITY FUNCTIONS
function formatDate($date, $format = 'd-m-Y')
{
    if (empty($date))
        return '';
    $dateObj = new DateTime($date);
    return $dateObj->format($format);
}

function sanitizeInput($input)
{
    global $conn;
    return $conn->real_escape_string(htmlspecialchars(trim($input)));
}

?>