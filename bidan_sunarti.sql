-- Create the database
CREATE DATABASE IF NOT EXISTS bidan_sunarti;
USE bidan_sunarti;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Patients table
CREATE TABLE IF NOT EXISTS pasien (
    nik VARCHAR(16) PRIMARY KEY,
    nama VARCHAR(30) NOT NULL,
    tempat_lahir VARCHAR(20),
    tanggal_lahir DATE,
    agama VARCHAR(6),
    umur INT,
    alamat VARCHAR(40),
    pekerjaan VARCHAR(15),
    pendidikan VARCHAR(15),
    status_pasien VARCHAR(15),
    nama_suami VARCHAR(25),
    no_hp VARCHAR(13),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Registration table
CREATE TABLE IF NOT EXISTS pendaftaran (
    no_reg VARCHAR(8) PRIMARY KEY,
    nik VARCHAR(16) NOT NULL,
    tanggal_masuk DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nik) REFERENCES pasien(nik) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Diagnosis table
CREATE TABLE IF NOT EXISTS diagnosis (
    kode_diagnosis VARCHAR(5) PRIMARY KEY,
    nama_diagnosis VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Actions table
CREATE TABLE IF NOT EXISTS tindakan (
    kode_tindakan VARCHAR(8) PRIMARY KEY,
    nama_tindakan VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Medicine table
CREATE TABLE IF NOT EXISTS obat (
    kode_obat VARCHAR(5) PRIMARY KEY,
    nama_obat VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Examination table
CREATE TABLE IF NOT EXISTS pemeriksaan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_reg VARCHAR(8) NOT NULL,
    tanggal DATE,
    tensi VARCHAR(6),
    berat_badan DECIMAL(5,2),
    lila DECIMAL(3,1),
    uk INT COMMENT 'Usia Kehamilan (minggu)',
    djj INT COMMENT 'Denyut Jantung Janin',
    tfu INT COMMENT 'Tinggi Fundus Uteri (cm)',
    gpa VARCHAR(3) COMMENT 'Gravida, Para, Abortus',
    hpht DATE COMMENT 'Hari Pertama Haid Terakhir',
    hpl DATE COMMENT 'Hari Perkiraan Lahir',
    air_ketuban VARCHAR(4),
    hasil_lab TEXT,
    keluhan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (no_reg) REFERENCES pendaftaran(no_reg) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Examination details table
CREATE TABLE IF NOT EXISTS pemeriksaan_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pemeriksaan_id INT NOT NULL,
    kode_diagnosis VARCHAR(5),
    kode_tindakan VARCHAR(8),
    kode_obat VARCHAR(5),
    hasil_usg TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pemeriksaan_id) REFERENCES pemeriksaan(id) ON DELETE CASCADE,
    FOREIGN KEY (kode_diagnosis) REFERENCES diagnosis(kode_diagnosis) ON DELETE SET NULL,
    FOREIGN KEY (kode_tindakan) REFERENCES tindakan(kode_tindakan) ON DELETE SET NULL,
    FOREIGN KEY (kode_obat) REFERENCES obat(kode_obat) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample admin user (password: "password")
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert sample diagnosis data
INSERT INTO diagnosis (kode_diagnosis, nama_diagnosis) VALUES
('D001', 'Kehamilan Normal'),
('D002', 'Anemia'),
('D003', 'Hipertensi'),
('D004', 'Diabetes Gestasional'),
('D005', 'Infeksi Saluran Kemih');

-- Insert sample actions data
INSERT INTO tindakan (kode_tindakan, nama_tindakan) VALUES
('T001', 'USG'),
('T002', 'Pemberian Fe'),
('T003', 'Pemantauan DJJ'),
('T004', 'Tes Toleransi Glukosa'),
('T005', 'Pemeriksaan Urin');

-- Insert sample medicine data
INSERT INTO obat (kode_obat, nama_obat) VALUES
('O001', 'Fe Tablet'),
('O002', 'Vitamin B Complex'),
('O003', 'Asam Folat'),
('O004', 'Antibiotik'),
('O005', 'Anti Hipertensi');

-- Insert sample patient data
INSERT INTO pasien (nik, nama, tempat_lahir, tanggal_lahir, agama, umur, alamat, pekerjaan, pendidikan, status_pasien, nama_suami, no_hp) VALUES
('3200123456789001', 'Siti Rahayu', 'Jakarta', '1990-05-15', 'Islam', 32, 'Jl. Merdeka No. 10', 'Ibu Rumah Tangga', 'SMA', 'Menikah', 'Budi Santoso', '081234567890'),
('3200123456789002', 'Dewi Lestari', 'Bandung', '1988-08-20', 'Islam', 34, 'Jl. Sudirman No. 5', 'Pegawai Swasta', 'D3', 'Menikah', 'Ahmad Fauzi', '081234567891'),
('3200123456789003', 'Rina Wijaya', 'Surabaya', '1992-03-10', 'Kristen', 30, 'Jl. Diponegoro No. 15', 'Guru', 'S1', 'Menikah', 'Joko Prasetyo', '081234567892');

-- Insert sample registration data
INSERT INTO pendaftaran (no_reg, nik, tanggal_masuk) VALUES
('REG001', '3200123456789001', '2023-01-10'),
('REG002', '3200123456789002', '2023-01-12'),
('REG003', '3200123456789003', '2023-01-15');

-- Insert sample examination data
INSERT INTO pemeriksaan (no_reg, tanggal, tensi, berat_badan, lila, uk, djj, tfu, gpa, hpht, hpl, air_ketuban, hasil_lab, keluhan) VALUES
('REG001', '2023-01-10', '120/80', 55.5, 25.5, 12, 140, 12, 'G1P0A0', '2022-10-15', '2023-07-22', 'J+', 'Hb: 12 g/dL', 'Mual di pagi hari'),
('REG002', '2023-01-12', '110/70', 58.0, 26.0, 16, 145, 16, 'G2P1A0', '2022-09-20', '2023-06-27', 'J+', 'Hb: 11 g/dL', 'Pusing ringan'),
('REG003', '2023-01-15', '130/85', 60.0, 27.0, 20, 150, 20, 'G3P2A0', '2022-08-10', '2023-05-17', 'J+', 'Hb: 10 g/dL', 'Nyeri pinggang');

-- Insert sample examination details
INSERT INTO pemeriksaan_detail (pemeriksaan_id, kode_diagnosis, kode_tindakan, kode_obat, hasil_usg) VALUES
(1, 'D001', 'T001', 'O001', 'Janin tunggal, usia kehamilan sesuai, denyut jantung janin normal'),
(2, 'D002', 'T002', 'O002', 'Janin tunggal, pertumbuhan normal, plasenta di posterior'),
(3, 'D003', 'T003', 'O005', 'Janin tunggal, pergerakan aktif, jumlah air ketuban normal');