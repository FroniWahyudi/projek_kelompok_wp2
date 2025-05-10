-- phpMyAdmin SQL Dump (diperbaiki & diurutkan)
-- Host: 127.0.0.1 | Server: 10.4.32-MariaDB | PHP 8.0.30
-- Dibuat: 06 Mei 2025, 12:48

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8mb4;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- 1) Tabel `users` (dengan kolom `alamat`)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `role` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `photo_url` VARCHAR(255) DEFAULT NULL,
  `bio` TEXT DEFAULT NULL,
  `alamat` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users`
  (`id`, `name`, `role`, `password`, `email`, `phone`, `photo_url`, `bio`, `alamat`, `created_at`)
VALUES
  (1, 'Alice Putri',   'HR',       '12345', 'alice.putri@nagahtam.co.id', '+62 812-3456-7890', 'img/nami.jpeg',
    'Mengelola administrasi karyawan.',
    'Jl. Merdeka No. 10, Jakarta Pusat',
    '2025-05-01 12:15:16'),
  (2, 'Budi Santoso',   'Leader',   '12345', 'budi.santoso@nagahtam.co.id', '+62 813-9876-5432', 'img/zoro.jpeg',
    'Memantau operator lapangan.',
    'Jl. Sudirman Kav. 12, Jakarta Selatan',
    '2025-05-01 12:15:16'),
  (3, 'Sanji',          'Leader',   '12345', 'sanji@nagahtam.co.id',        '+62 813-9876-5432', 'img/sanji.jpeg',
    'Memantau operator lapangan.',
    'Jl. Pahlawan No. 3, Surabaya',
    '2025-05-01 12:15:16'),
  (4, 'Sutoyo dono',    'Manajer',  'sutoyo123', 'sutoyo@nagahtam.co.id',    '+62 812-1234-5678', 'img/sutoyo.jpg',
    'Pengambilan keputusan strategis.',
    'Jl. Diponegoro No. 20, Semarang',
    '2025-05-01 22:41:16'),
  (6, 'Ahmad Yusuf',    'Karyawan', 'karyawan123', 'ahmad.yusuf@nagahtam.co.id', '+62 812-3456-7890', 'img/ahmad_yusuf.jpg',
    'Administrasi karyawan.',
    'Jl. Gajah Mada No. 15, Yogyakarta',
    '2025-05-01 23:20:02'),
  (7, 'Wanda',          'Karyawan', 'karyawan123', 'wanda@nagahtam.co.id',    '+62 813-9876-5432', 'img/wanda.jpg',
    'Supervisor operasional.',
    'Jl. Pemuda No. 7, Bekasi',
    '2025-05-01 23:20:02'),
  (8, 'Agus',           'Karyawan', 'karyawan123', 'agus@nagahtam.co.id',      '+62 813-9876-5432', 'img/budi.jpg',
    'Operator produksi.',
    'Jl. Raya Bogor No. 45, Depok',
    '2025-05-01 23:20:02'),
  (9, 'Lina Marlina',   'Karyawan', 'karyawan123', 'lina.marlina@nagahtam.co.id', '+62 812-1234-5678', 'img/lina.jpg',
    'Manager divisi.',
    'Jl. Sultan Iskandar Muda No. 8, Medan',
    '2025-05-01 23:20:02'),
  (10,'Rudi Hartanto',  'Karyawan', 'karyawan123', 'rudi.hartono@nagahtam.co.id', '+62 813-5678-9012', 'img/rudi.jpg',
    'Staf gudang.',
    'Jl. Bumi Raya No. 9, Palembang',
    '2025-05-01 23:20:02');

-- --------------------------------------------------------
-- 2) Tabel `sisa_cuti`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sisa_cuti` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `tahun` YEAR(4) NOT NULL,
  `total_cuti` INT(11) DEFAULT 12,
  `cuti_terpakai` INT(11) DEFAULT 0,
  `cuti_sisa` INT(11) AS (`total_cuti` - `cuti_terpakai`) STORED,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_year` (`user_id`,`tahun`),
  CONSTRAINT `fk_sisa_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sisa_cuti` (`id`, `user_id`, `tahun`, `total_cuti`, `cuti_terpakai`) VALUES
(1, 8, '2025', 12, 0),
(2, 6, '2025', 12, 0),
(3, 9, '2025', 12, 0),
(4, 10, '2025', 12, 5),
(5, 7, '2025', 12, 5);

-- --------------------------------------------------------
-- 3) Tabel `cuti_requests`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cuti_requests` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `tanggal_pengajuan` DATE NOT NULL,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `lama_cuti` INT(11) NOT NULL,
  `alasan` TEXT NOT NULL,
  `status` ENUM('Menunggu','Disetujui','Ditolak') DEFAULT 'Menunggu',
  `disetujui_oleh` INT(11) DEFAULT NULL,
  `tanggal_disetujui` DATE DEFAULT NULL,
  `catatan_hr` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `req_user` (`user_id`),
  KEY `req_approval` (`disetujui_oleh`),
  CONSTRAINT `fk_req_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  CONSTRAINT `fk_req_approval` FOREIGN KEY (`disetujui_oleh`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cuti_requests` (`id`, `user_id`, `tanggal_pengajuan`, `tanggal_mulai`, `tanggal_selesai`, `lama_cuti`, `alasan`, `status`, `disetujui_oleh`, `tanggal_disetujui`, `catatan_hr`, `created_at`, `updated_at`) VALUES
(2, 7, '2025-05-05', '2025-05-06', '2025-05-10', 5, 'kakek sakit', 'Disetujui', 1, '2025-05-05', NULL, '2025-05-04 22:49:44', '2025-05-04 22:50:06'),
(3, 10, '2025-05-05', '2025-05-06', '2025-05-10', 5, 'mager', 'Disetujui', 1, '2025-05-05', NULL, '2025-05-05 02:15:06', '2025-05-05 04:22:41');

-- --------------------------------------------------------
-- 4) Tabel `cuti_logs`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cuti_logs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `cuti_request_id` INT(11) NOT NULL,
  `aksi` VARCHAR(50) DEFAULT NULL,
  `oleh_user_id` INT(11) NOT NULL,
  `waktu` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_request` (`cuti_request_id`),
  KEY `log_user` (`oleh_user_id`),
  CONSTRAINT `fk_log_request` FOREIGN KEY (`cuti_request_id`) REFERENCES `cuti_requests`(`id`),
  CONSTRAINT `fk_log_user` FOREIGN KEY (`oleh_user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cuti_logs` (`id`, `cuti_request_id`, `aksi`, `oleh_user_id`, `waktu`, `keterangan`) VALUES
(3, 2, 'Dibuat', 7, '2025-05-04 22:49:44', 'Pengajuan dibuat'),
(4, 2, 'Disetujui', 1, '2025-05-04 22:50:06', 'Diterima oleh HR'),
(5, 3, 'Dibuat', 10, '2025-05-05 02:15:06', 'Pengajuan dibuat'),
(6, 3, 'Disetujui', 1, '2025-05-05 04:22:41', 'Diterima oleh HR');

-- --------------------------------------------------------
-- 5) Tabel `laporan_kerja`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `laporan_kerja` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tanggal` DATE NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `divisi` VARCHAR(100) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `laporan_kerja` (`id`, `tanggal`, `nama`, `divisi`, `deskripsi`, `created_at`) VALUES
(2, '2025-05-21', 'Froni', 'HR specialist', 'Gudang keluarkan 250 unit.', '2025-05-02 12:12:42'),
(3, '2025-05-05', 'Froni Wahyudi', 'Operator Gudang', 'Barang keluar 300 unit.', '2025-05-05 09:14:38');

-- --------------------------------------------------------
-- 6) Tabel `news`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `news` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `date` DATE NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `link` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `news` (`id`, `title`, `date`, `image_url`, `description`, `link`) VALUES
(1, 'Pengembangan Produk Inovatif', '2025-06-29', 'img/karyawan_inovasi.png', 'Tim R&D berhasil menciptakan formula baru yang meningkatkan efisiensi produk sebesar 30% berdasarkan hasil uji laboratorium.\n\nPengujian akan dilanjutkan pada skala produksi untuk validasi performa dan penghematan biaya operasional.', 'whats_new.php?id=1'),
(2, 'Promosi Jabatan', '2025-06-29', 'img/naik_jabatan.png', 'Sebanyak 5 karyawan dari berbagai divisi mendapat promosi berdasarkan evaluasi kinerja semester pertama 2025.\n\nMereka akan segera mengikuti pelatihan kepemimpinan sebagai bagian dari pengembangan karier.', 'whats_new.php?id=2'),
(3, 'Rapat Strategi Bisnis', '2025-06-29', 'img/rapat_kenaikan_harga.png', 'Manajemen menggelar rapat koordinasi untuk merespons kenaikan harga bahan baku impor yang berdampak pada biaya produksi.\n\nLangkah antisipatif dan strategi efisiensi akan diterapkan dalam kuartal berikutnya.', 'whats_new.php?id=3'),
(4, 'Pembaruan Sistem Tracking', '2025-06-29', 'img/pembaruan_sistem_tracking.png', 'Departemen IT telah memperbarui sistem pelacakan logistik dengan teknologi GPS real-time.\n\nPembaruan ini memungkinkan pemantauan pergerakan barang secara lebih akurat dan efisien.', 'whats_new.php?id=4'),
(5, 'Peningkatan Fasilitas Gudang', '2025-06-29', 'img/peningkatan_gudang.png', 'Fasilitas gudang di cabang pusat kini dilengkapi rak penyimpanan otomatis dan sistem kontrol suhu terintegrasi.\n\nLangkah ini mendukung penanganan produk lebih cepat dan menjaga kualitas barang yang sensitif.', 'whats_new.php?id=5'),
(6, 'Integrasi Aplikasi Mobile', '2025-07-01', 'img/integrasi_mobile.png', 'Divisi lapangan kini dapat melaporkan data langsung melalui aplikasi mobile yang telah terintegrasi dengan server pusat.\n\nFitur ini mempercepat alur komunikasi dan pelaporan secara real-time.', 'whats_new.php?id=6');


-- --------------------------------------------------------
-- 7) Tabel `payrolls`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `payrolls` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `periode` CHAR(7) NOT NULL COMMENT 'YYYY-MM',
  `gaji_pokok` DECIMAL(15,2) NOT NULL,
  `tunjangan` DECIMAL(15,2) NOT NULL,
  `potongan` DECIMAL(15,2) NOT NULL,
  `total_gaji` DECIMAL(15,2) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pay_user` (`user_id`),
  KEY `pay_per` (`periode`),
  CONSTRAINT `fk_pay_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `payrolls` (`user_id`, `periode`, `gaji_pokok`, `tunjangan`, `potongan`, `total_gaji`, `created_at`) VALUES
(1, '2025-05', 5000000.00,1000000.00,200000.00,5800000.00,'2025-05-01 08:00:00'),
(2, '2025-05', 4500000.00, 800000.00,150000.00,5150000.00,'2025-05-01 08:05:00'),
(3, '2025-05', 4500000.00, 800000.00,150000.00,5150000.00,'2025-05-01 08:10:00'),
(4, '2025-05', 7000000.00,1500000.00,250000.00,8250000.00,'2025-05-01 08:15:00'),
(6, '2025-05', 4000000.00, 500000.00,100000.00,4400000.00,'2025-05-01 08:20:00'),
(7, '2025-05', 4000000.00, 500000.00,100000.00,4400000.00,'2025-05-01 08:25:00'),
(8, '2025-05', 4000000.00, 500000.00,100000.00,4400000.00,'2025-05-01 08:30:00'),
(9, '2025-05', 6000000.00,1200000.00,200000.00,7000000.00,'2025-05-01 08:35:00'),
(10,'2025-05', 3800000.00, 400000.00, 80000.00,4120000.00,'2025-05-01 08:40:00');

-- --------------------------------------------------------
-- 8) Tabel `shift_karyawan`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `shift_karyawan` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `tanggal` DATE NOT NULL,
  `shift` ENUM('Pagi','Sore') NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `shift_user` (`user_id`),
  KEY `shift_tgl` (`tanggal`),
  CONSTRAINT `fk_shift_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `shift_karyawan` (`user_id`, `tanggal`, `shift`, `created_at`) VALUES
(1, '2025-05-01', 'Pagi', '2025-05-01 07:00:00'),
(2, '2025-05-01', 'Sore', '2025-05-01 15:00:00'),
(3, '2025-05-02', 'Pagi', '2025-05-02 07:00:00'),
(4, '2025-05-02', 'Sore', '2025-05-02 15:00:00'),
(6, '2025-05-03', 'Pagi', '2025-05-03 07:00:00'),
(7, '2025-05-03', 'Sore', '2025-05-03 15:00:00');
