-- phpMyAdmin SQL Dump (diperbaiki & diurutkan)
-- Host: 127.0.0.1 | Server: 10.4.32-MariaDB | PHP 8.0.30
-- Dibuat: 06 Mei 2025, 12:48

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8mb4;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Tabel `users` dengan job_descriptions, skills, achievements bertipe TEXT
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11)               NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100)        NOT NULL,
  `role` VARCHAR(50)         NOT NULL,
  `password` VARCHAR(255)    NOT NULL,
  `email` VARCHAR(100)       DEFAULT NULL,
  `phone` VARCHAR(20)        DEFAULT NULL,
  `photo_url` VARCHAR(255)   DEFAULT NULL,
  `bio` TEXT                 DEFAULT NULL,
  `alamat` VARCHAR(255)      DEFAULT NULL,
  `joined_at` DATE           DEFAULT NULL,
  `education` VARCHAR(255)   DEFAULT NULL,
  `department` VARCHAR(100)  DEFAULT NULL,
  `level` VARCHAR(50)        DEFAULT NULL,
  `job_descriptions` TEXT    DEFAULT NULL,
  `skills` TEXT              DEFAULT NULL,
  `achievements` TEXT        DEFAULT NULL,
  `created_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Data lengkap: baris 1–5 (asli) dan baris 6–10 (nama laki-laki, photo_url diubah)
-- --------------------------------------------------------
-- --------------------------------------------------------
-- Insert data lengkap: baris 1–5 asli, baris 6–10 diubah role jadi 'Operator'
-- dengan aktivitas gudang (sortir, packing, inventory)
-- --------------------------------------------------------
-- --------------------------------------------------------
-- Insert data lengkap: baris 1–5 asli, baris 6–35 sebagai 'Operator'
-- (total 30 operator, aktivitas gudang: sortir, packing, inventory)
-- --------------------------------------------------------
INSERT INTO `users`
  (`id`, `name`, `role`, `password`, `email`, `phone`, `photo_url`, `bio`, `alamat`,
   `joined_at`, `education`, `department`, `level`,
   `job_descriptions`, `skills`, `achievements`, `created_at`)
VALUES
  -- 1–5 data awal
  (1,  'Alice Putri',    'Admin',   '12345',        'alice.putri@nagahtam.co.id',  '+62 812-3456-7890',   'img/nami.jpeg',
   'Mengelola administrasi karyawan.',
   'Jl. Merdeka No. 10, Jakarta Pusat',
   '2018-01-15','SI Manajemen, Universitas Indonesia','HR','Senior',
   'Rekrutmen dan seleksi karyawan, Pengelolaan data karyawan, Pelatihan dan onboarding',
   'Komunikasi, Microsoft Excel, Manajemen SDM',
   'Employee of the Year 2020, Penyusunan SOP HR',
   '2025-05-01 12:15:16'
  ),
  (2,  'Budi Santoso',   'Leader',  '12345',        'budi.santoso@nagahtam.co.id', '+62 813-9876-5432',   'img/zoro.jpeg',
   'Memantau operator lapangan.',
   'Jl. Sudirman Kav. 12, Jakarta Selatan',
   '2019-03-10','Teknik Industri, Institut Teknologi Bandung','Operasional','Mid-level',
   'Koordinasi tim lapangan, Laporan harian produksi',
   'Leadership, Problem Solving, Safety Management',
   'Tim terbaik Q4 2021',
   '2025-05-01 12:15:16'
  ),
  (3,  'Sanji',          'Leader',  '12345',        'sanji@nagahtam.co.id',         '+62 813-9876-5432',   'img/sanji.jpeg',
   'Memantau operator lapangan.',
   'Jl. Pahlawan No. 3, Surabaya',
   '2020-07-22','Teknik Mesin, Universitas Negeri Surabaya','Operasional','Mid-level',
   'Jadwal shift operator, Optimasi workflow produksi',
   'Time Management, Maintenance Planning',
   'Pengurangan downtime 15%',
   '2025-05-01 12:15:16'
  ),
  (4,  'Sutoyo Dono',    'Manajer', 'sutoyo123',    'sutoyo@nagahtam.co.id',        '+62 812-1234-5678',   'img/sutoyo.jpg',
   'Pengambilan keputusan strategis.',
   'Jl. Diponegoro No. 20, Semarang',
   '2015-11-05','Magister Manajemen, Universitas Gadjah Mada','Manajemen','Senior',
   'Perencanaan strategi perusahaan, Koordinasi antar-departemen',
   'Strategic Planning, Negotiation',
   'Penghargaan Leader of the Year 2019',
   '2025-05-01 22:41:16'
  ),
  (5,  'Putri Tanjung',  'Admin',   'putri123',     'putri.tanjung@nagahtam.co.id', '+62 813-4567-8901',   'img/putri_tanjung.jpg',
   'Mengelola administrasi dan koordinasi tim.',
   'Jl. Melati No. 12, Bandung',
   '2019-05-20','Administrasi Bisnis, Universitas Padjadjaran','Administrasi','Senior',
   'Membuat laporan bulanan, Koordinasi dengan manajemen',
   'Microsoft Office, Komunikasi, Manajemen Proyek',
   'Employee of the Month 2022',
   '2025-05-06 10:00:00'
  ),

  -- 6–35: Operator gudang
  (6,  'Ahmad Yusuf',    'Operator','karyawan123',    'ahmad.yusuf@nagahtam.co.id',    '+62 812-3456-7890',  'img/profil_operator.jpg',
   'Bertanggung jawab proses sortir dan packing barang.',
   'Jl. Gajah Mada No. 15, Yogyakarta','2021-02-18','Administrasi Bisnis, UNDIP','Gudang','Junior',
   'Sortir barang, Packing pesanan, Cek inventory',
   'Ketelitian, Kecepatan, Barcode scanning',
   'Zero Error Packing 2022','2025-05-01 23:20:02'
  ),
  (7,  'Wandi Kurnia',   'Operator','karyawan123',    'wandi.kurnia@nagahtam.co.id',    '+62 813-9876-5432',  'img/profil_operator.jpg',
   'Menerima, sortir kualitas, dan packing kiriman.',
   'Jl. Pemuda No. 7, Bekasi','2017-08-30','Manaj. Operasional, UNPAD','Gudang','Senior',
   'Penerimaan barang, Sortir kualitas, Packing & labeling',
   'QC, Supervisi, Komunikasi',
   'Akurasi 99% 2021','2025-05-01 23:20:02'
  ),
  (8,  'Agus Santoso',   'Operator','karyawan123',    'agus.santoso@nagahtam.co.id',    '+62 813-9876-5432',  'img/profil_operator.jpg',
   'Operator gudang: sortir, packing, tata rak.',
   'Jl. Raya Bogor No. 45, Depok','2022-04-12','Teknik Kimia, IST','Gudang','Junior',
   'Packing barang, Tata rak, Pengecekan batch',
   'Organisasi, Machine Op','Zero Defect April 2023','2025-05-01 23:20:02'
  ),
  (9,  'Rian Marlino',   'Operator','karyawan123',    'rian.marlino@nagahtam.co.id',   '+62 812-1234-5678',  'img/profil_operator.jpg',
   'Menjalankan sortir otomatis & manual.',
   'Jl. Sultan Iskandar No. 8, Medan','2016-06-21','S2 Manajemen, USU','Gudang','Senior',
   'Sortir otomatis, Maintenance, Packing ekspor',
   'Monitoring, Maintenance','Divisi Terbaik 2022','2025-05-01 23:20:02'
  ),
  (10, 'Rudi Hartanto',  'Operator','karyawan123',    'rudi.hartanto@nagahtam.co.id',  '+62 813-5678-9012',  'img/profil_operator.jpg',
   'Cek inventori, packing, koordinasi kiriman.',
   'Jl. Bumi Raya No. 9, Palembang','2019-09-14','Logistik, UNSRI','Gudang','Mid-level',
   'Audit inventory, Packing, Koordinasi ekspedisi',
   'Inventory Mgmt, Forklift','On-Time Delivery 2021','2025-05-01 23:20:02'
  ),
  (11, 'Andi Prasetyo',  'Operator','karyawan123',    'andi.prasetyo@nagahtam.co.id',  '+62 811-0000-0001',  'img/profil_operator.jpg',
   'Sorting barang masuk dan penataan rak.',
   'Jl. Merpati No. 11, Bandung','2020-01-05','Manajemen, UNPAD','Gudang','Junior',
   'Sortir, Penataan rak, Packing',
   'Ketelitian, Kecepatan','Best Sorter 2020','2025-05-02 09:00:00'
  ),
  (12, 'Budi Hartono',   'Operator','karyawan123',    'budi.hartono@nagahtam.co.id',   '+62 811-0000-0002',  'img/profil_operator.jpg',
   'Memproses packing dan labeling pesanan.',
   'Jl. Kenari No. 12, Jakarta Utara','2018-03-10','Logistik, UI','Gudang','Junior',
   'Packing, Labeling, QC',
   'Label Accuracy, Packing Speed','Employee of Month Mar 2022','2025-05-02 09:00:00'
  ),
  (13, 'Candra Wijaya',  'Operator','karyawan123',    'candra.wijaya@nagahtam.co.id',  '+62 811-0000-0003',  'img/profil_operator.jpg',
   'Bertugas terima barang dan sortir kualitas.',
   'Jl. Kenanga No. 13, Surabaya','2019-05-21','Teknik Industri, ITS','Gudang','Junior',
   'Penerimaan barang, Sortir QC','QC, Data Entry','Zero Defect Jun 2023','2025-05-02 09:00:00'
  ),
  (14, 'Dedi Saputra',   'Operator','karyawan123',    'dedi.saputra@nagahtam.co.id',   '+62 811-0000-0004',  'img/profil_operator.jpg',
   'Melakukan packing & persiapan kirim.',
   'Jl. Pelita No. 14, Medan','2020-07-15','Logistik, USU','Gudang','Mid-level',
   'Packing, Koordinasi kirim','Logistik, Forklift','Best Packer 2021','2025-05-02 09:00:00'
  ),
  (15, 'Eko Prabowo',    'Operator','karyawan123',    'eko.prabowo@nagahtam.co.id',    '+62 811-0000-0005',  'img/profil_operator.jpg',
   'Menata ulang rak dan inventory check.',
   'Jl. Mangga No. 15, Semarang','2021-11-30','Manajemen, UGM','Gudang','Junior',
   'Rak organization, Inventory check',
   'Detail-oriented','Inventory Hero 2023','2025-05-02 09:00:00'
  ),
  (16, 'Fajar Nugroho',  'Operator','karyawan123',    'fajar.nugroho@nagahtam.co.id',  '+62 811-0000-0006',  'img/profil_operator.jpg',
   'Supervisor packing shift malam.',
   'Jl. Anggrek No. 16, Bekasi','2017-02-18','Manajemen, UNPAD','Gudang','Senior',
   'Supervisi packing, QC','Leadership','Night Shift Star','2025-05-02 09:00:00'
  ),
  (17, 'Galih Santoso',  'Operator','karyawan123',    'galih.santoso@nagahtam.co.id',  '+62 811-0000-0007',  'img/profil_operator.jpg',
   'Mengelola sortir manual dan mesin.',
   'Jl. Melur No. 17, Bandung','2018-10-10','Teknik Mesin, ITB','Gudang','Mid-level',
   'Sortir manual & mesin','Machine Ops','Sort Master 2022','2025-05-02 09:00:00'
  ),
  (18, 'Hadi Wijaya',    'Operator','karyawan123',    'hadi.wijaya@nagahtam.co.id',    '+62 811-0000-0008',  'img/profil_operator.jpg',
   'Menangani return barang & QC ulang.',
   'Jl. Dahlia No. 18, Surabaya','2019-12-01','Teknik Industri, ITS','Gudang','Junior',
   'Return processing, Re-QC','QC','Return King 2022','2025-05-02 09:00:00'
  ),
  (19, 'Iwan Setiawan',  'Operator','karyawan123',    'iwan.setiawan@nagahtam.co.id',  '+62 811-0000-0009',  'img/profil_operator.jpg',
   'Koordinasi forklift & stoking rak.',
   'Jl. Flamboyan No. 19, Jakarta Timur','2020-04-22','Logistik, UI','Gudang','Junior',
   'Forklift operation, Stoking','Forklift','Forklift Ace 2023','2025-05-02 09:00:00'
  ),
  (20, 'Joko Susilo',    'Operator','karyawan123',    'joko.susilo@nagahtam.co.id',    '+62 811-0000-0010',  'img/profil_operator.jpg',
   'Mengemas barang besar & berat.',
   'Jl. Kenari No. 20, Palembang','2021-08-05','Teknik Mesin, UNSRI','Gudang','Mid-level',
   'Heavy item packing','Strength, Teamwork','Heavy Lifter Award','2025-05-02 09:00:00'
  ),
  (21, 'Krisna Aditya',  'Operator','karyawan123',    'krisna.aditya@nagahtam.co.id',  '+62 811-0000-0011',  'img/profil_operator.jpg',
   'Packing kilat & drop-shipping.',
   'Jl. Bambu No. 21, Depok','2022-02-14','Manajemen, UNDIP','Gudang','Junior',
   'Express packing','Speed Packing','Flash Packer','2025-05-02 09:00:00'
  ),
  (22, 'Lukman Hakim',   'Operator','karyawan123',    'lukman.hakim@nagahtam.co.id',   '+62 811-0000-0012',  'img/profil_operator.jpg',
   'QC akhir sebelum kirim.',
   'Jl. Cemara No. 22, Medan','2018-06-18','Manajemen, USU','Gudang','Senior',
   'Final QC','QC, Detail','QC Champion','2025-05-02 09:00:00'
  ),
  (23, 'Miko Pratama',   'Operator','karyawan123',    'miko.pratama@nagahtam.co.id',   '+62 811-0000-0013',  'img/profil_operator.jpg',
   'Input data inventory & sortir.',
   'Jl. Anggrek No. 23, Yogyakarta','2019-09-30','Administrasi, UGM','Gudang','Junior',
   'Data entry inventory, Sortir','MS Excel','Data Star','2025-05-02 09:00:00'
  ),
  (24, 'Novan Ryan',     'Operator','karyawan123',    'novan.ryan@nagahtam.co.id',     '+62 811-0000-0014',  'img/profil_operator.jpg',
   'Menangani packing pesanan e-commerce.',
   'Jl. Melati No. 24, Bandung','2020-11-11','Logistik, UNPAD','Gudang','Mid-level',
   'E-commerce packing','Speed & Care','E-commerce Hero','2025-05-02 09:00:00'
  ),
  (25, 'Oki Subandi',    'Operator','karyawan123',    'oki.subandi@nagahtam.co.id',    '+62 811-0000-0015',  'img/profil_operator.jpg',
   'Sortir barang elektronik.',
   'Jl. Kenanga No. 25, Bekasi','2021-03-03','Teknik Elektro, UI','Gudang','Junior',
   'Sortir elektronik','Delicate handling','Electronics Ace','2025-05-02 09:00:00'
  ),
  (26, 'Prio Nugroho',   'Operator','karyawan123',    'prio.nugroho@nagahtam.co.id',   '+62 811-0000-0016',  'img/profil_operator.jpg',
   'Koordinasi tim packing shift pagi.',
   'Jl. Anggrek No. 26, Jakarta Barat','2018-12-12','Manajemen, UI','Gudang','Senior',
   'Team coordination','Leadership','Morning Lead','2025-05-02 09:00:00'
  ),
  (27, 'Qori Fahmi',     'Operator','karyawan123',    'qori.fahmi@nagahtam.co.id',     '+62 811-0000-0017',  'img/profil_operator.jpg',
   'Memeriksa kondisi packing & material.',
   'Jl. Bumi No. 27, Semarang','2019-07-29','Teknik Material, UGM','Gudang','Junior',
   'Material inspection','QC, Material science','Material Master','2025-05-02 09:00:00'
  ),
  (28, 'Raden Hadi',     'Operator','karyawan123',    'raden.hadi@nagahtam.co.id',     '+62 811-0000-0018',  'img/profil_operator.jpg',
   'Penataan ulang clusters barang.',
   'Jl. Sawit No. 28, Surabaya','2020-05-20','Manajemen, ITS','Gudang','Mid-level',
   'Cluster organization','Organization','Cluster Champ','2025-05-02 09:00:00'
  ),
  (29, 'Sandi Permana',  'Operator','karyawan123',    'sandi.permana@nagahtam.co.id',  '+62 811-0000-0019',  'img/profil_operator.jpg',
   'Mengelola retur dan recycle packing.',
   'Jl. Durian No. 29, Yogyakarta','2021-10-10','Administrasi, UNDIP','Gudang','Junior',
   'Return handling','Recycling','Return Star','2025-05-02 09:00:00'
  ),
  (30, 'Tony Wijaya',    'Operator','karyawan123',    'tony.wijaya@nagahtam.co.id',    '+62 811-0000-0020',  'img/profil_operator.jpg',
   'Melakukan pengepakan besar dan berat.',
   'Jl. Rambutan No. 30, Medan','2018-08-08','Teknik Mesin, USU','Gudang','Mid-level',
   'Heavy item packing','Strength, Teamwork','Heavy Lifter','2025-05-02 09:00:00'
  ),
  (31, 'Udin Setiawan',  'Operator','karyawan123',    'udin.setiawan@nagahtam.co.id',  '+62 811-0000-0021',  'img/profil_operator.jpg',
   'Sorting express shipments.',
   'Jl. Melur No. 31, Bandung','2019-02-14','Logistik, UNPAD','Gudang','Junior',
   'Express sorting','Speed','Express Ace','2025-05-02 09:00:00'
  ),
  (32, 'Vito Rinaldi',   'Operator','karyawan123',    'vito.rinaldi@nagahtam.co.id',   '+62 811-0000-0022',  'img/profil_operator.jpg',
   'QC sample batch sebelum packing.',
   'Jl. Pinus No. 32, Bekasi','2020-09-09','Teknik Kimia, ITB','Gudang','Junior',
   'Batch QC','Attention to detail','Batch Star','2025-05-02 09:00:00'
  ),
  (33, 'Willy Prakoso',  'Operator','karyawan123',    'willy.prakoso@nagahtam.co.id',  '+62 811-0000-0023',  'img/profil_operator.jpg',
   'Menangani logistik internal gudang.',
   'Jl. Flamboyan No. 33, Jakarta Timur','2021-06-06','Logistik, UI','Gudang','Mid-level',
   'Internal logistics','Coordination','Logistic Hero','2025-05-02 09:00:00'
  ),
  (34, 'Xavier Paul',    'Operator','karyawan123',    'xavier.paul@nagahtam.co.id',    '+62 811-0000-0024',  'img/profil_operator.jpg',
   'Memproses pengiriman ekspor.',
   'Jl. Kenanga No. 34, Surabaya','2018-04-04','Logistik, ITS','Gudang','Senior',
   'Export processing','Export regulations','Export Champion','2025-05-02 09:00:00'
  ),
  (35, 'Yusuf Ramadhan', 'Operator','karyawan123',    'yusuf.ramadhan@nagahtam.co.id','+62 811-0000-0025','img/profil_operator.jpg',
   'Koordinasi pengiriman last-mile.',
   'Jl. Kemuning No. 35, Medan','2019-11-11','Manajemen, USU','Gudang','Mid-level',
   'Last-mile coordination','Communication','Last Mile Star','2025-05-02 09:00:00'
  );



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
(1, 'Pengembangan Produk Inovatif', '2025-06-29', 'img/karyawan_inovasi.png', 'Tim Riset dan Pengembangan (R\&D) telah berhasil merancang sebuah formula baru yang mampu meningkatkan efisiensi produk secara signifikan. Pencapaian ini merupakan hasil dari proses penelitian mendalam yang menggabungkan pendekatan ilmiah dan pengalaman praktis tim dalam memahami karakteristik bahan serta kebutuhan proses produksi. Inovasi ini merupakan bagian dari komitmen berkelanjutan perusahaan dalam meningkatkan kualitas dan daya saing produk di pasar.

Berdasarkan hasil uji laboratorium yang dilakukan secara intensif, formula baru ini menunjukkan peningkatan efisiensi hingga 30 persen dibandingkan dengan versi sebelumnya. Pengujian dilakukan dengan parameter yang terukur dan berstandar, yang menunjukkan bahwa formula tersebut mampu bekerja lebih optimal dalam kondisi simulasi produksi. Efisiensi yang diperoleh tidak hanya berdampak pada peningkatan output, tetapi juga pada pengurangan konsumsi bahan baku.

Meskipun hasil uji laboratorium sangat menjanjikan, validasi lebih lanjut tetap diperlukan untuk memastikan bahwa peningkatan efisiensi tersebut dapat diterapkan secara konsisten dalam skala besar. Oleh karena itu, pengujian akan dilanjutkan pada tahap produksi nyata guna mengukur performa formula di lingkungan operasional yang sesungguhnya. Hal ini bertujuan untuk mengidentifikasi kemungkinan penyesuaian serta memastikan kestabilan hasil dalam proses berkelanjutan.

Selain mengukur kinerja teknis, uji produksi ini juga akan difokuskan pada aspek penghematan biaya operasional. Diharapkan, dengan penerapan formula baru ini, perusahaan dapat menekan biaya tanpa mengurangi kualitas produk akhir. Jika hasilnya sesuai harapan, maka formula ini akan menjadi bagian penting dari strategi efisiensi jangka panjang perusahaan dan akan diimplementasikan secara luas dalam proses produksi mendatang.
', 'whats_new.php?id=1'),
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
