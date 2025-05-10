-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Bulan Mei 2025 pada 12.48
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `naga_hytam`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti_logs`
--

CREATE TABLE `cuti_logs` (
  `id` int(11) NOT NULL,
  `cuti_request_id` int(11) NOT NULL,
  `aksi` varchar(50) DEFAULT NULL,
  `oleh_user_id` int(11) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cuti_logs`
--

INSERT INTO `cuti_logs` (`id`, `cuti_request_id`, `aksi`, `oleh_user_id`, `waktu`, `keterangan`) VALUES
(3, 2, 'Dibuat', 7, '2025-05-04 22:49:44', 'Pengajuan dibuat'),
(4, 2, 'Disetujui', 1, '2025-05-04 22:50:06', 'Diterima oleh HR'),
(5, 3, 'Dibuat', 10, '2025-05-05 02:15:06', 'Pengajuan dibuat'),
(6, 3, 'Disetujui', 1, '2025-05-05 04:22:41', 'Diterima oleh HR');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti_requests`
--

CREATE TABLE `cuti_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `lama_cuti` int(11) NOT NULL,
  `alasan` text NOT NULL,
  `status` enum('Menunggu','Disetujui','Ditolak') DEFAULT 'Menunggu',
  `disetujui_oleh` int(11) DEFAULT NULL,
  `tanggal_disetujui` date DEFAULT NULL,
  `catatan_hr` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cuti_requests`
--

INSERT INTO `cuti_requests` (`id`, `user_id`, `tanggal_pengajuan`, `tanggal_mulai`, `tanggal_selesai`, `lama_cuti`, `alasan`, `status`, `disetujui_oleh`, `tanggal_disetujui`, `catatan_hr`, `created_at`, `updated_at`) VALUES
(2, 7, '2025-05-05', '2025-05-06', '2025-05-10', 5, 'kakek sakit\r\n', 'Disetujui', 1, '2025-05-05', NULL, '2025-05-04 22:49:44', '2025-05-04 22:50:06'),
(3, 10, '2025-05-05', '2025-05-06', '2025-05-10', 5, 'mager\r\n', 'Disetujui', 1, '2025-05-05', NULL, '2025-05-05 02:15:06', '2025-05-05 04:22:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_kerja`
--

CREATE TABLE `laporan_kerja` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama` varchar(100) NOT NULL,
  `divisi` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `laporan_kerja`
--

INSERT INTO `laporan_kerja` (`id`, `tanggal`, `nama`, `divisi`, `deskripsi`, `created_at`) VALUES
(2, '2025-05-21', 'Froni ', 'HR specialist', 'target sudah tercapai ,gudang sudah mengeluarkan barang sebanyak 250 unit', '2025-05-02 12:12:42'),
(3, '2025-05-05', 'Froni Wahyudi', 'Operator Gudang', 'barang sudah keluar 300 unit\r\n', '2025-05-05 09:14:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `date` date NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `title`, `date`, `image_url`, `description`, `link`) VALUES
(1, 'Pengembangan Produk Inovatif', '2025-06-29', 'img/karyawan_inovasi.png', 'Tim R&D kami telah menyelesaikan serangkaian pengujian ekstensif terhadap prototipe produk inovatif yang menggabungkan material komposit ramah lingkungan dan teknologi penghematan energi terkini. Hasil uji laboratorium menunjukkan peningkatan performa hingga 30% serta pengurangan konsumsi energi hampir 20%, sekaligus menjaga stabilitas suhu operasional di bawah ambang batas keamanan. Fase uji lapangan kini melibatkan mitra strategis dan pelanggan pilot, dengan target validasi kualitas dan skalabilitas produksi massal dalam dua bulan ke depan. Rencana peluncuran komersial dijadwalkan pada kuartal berikutnya, lengkap dengan dukungan layanan purna jual dan pelatihan teknis untuk memastikan adopsi optimal di berbagai sektor industri.', 'whats_new.php?id=1'),
(2, 'Promosi Jabatan', '2025-06-29', 'img/naik_jabatan.png', 'Sebagai bagian dari upaya membangun budaya meritokrasi, perusahaan telah memberikan promosi jabatan kepada karyawan terpilih yang menunjukkan prestasi luar biasa dalam proyek strategis dan pengembangan tim. Setiap kandidat dinilai berdasarkan pencapaian KPI, kualitas kepemimpinan, serta kontribusi inovatif dalam proses kerja-mulai dari efisiensi biaya hingga peningkatan kepuasan pelanggan. Upacara serah terima jabatan akan diselenggarakan dalam bentuk webinar interaktif, di mana para penerima promosi akan berbagi wawasan dan rencana aksi mereka untuk semester mendatang. Dokumen resmi yang memuat daftar nama, jabatan baru, dan uraian tanggung jawab terbaru dapat diunduh dari portal HR di menu Pengumuman.', 'whats_new.php?id=2'),
(3, 'Rapat Strategi Bisnis', '2025-06-29', 'img/rapat_kenaikan_harga.png', 'Dalam rapat strategi bisnis lintas divisi, pimpinan perusahaan memimpin diskusi mendalam mengenai dinamika harga bahan baku global yang berdampak langsung pada struktur biaya produksi. Pertemuan ini melibatkan tim pemasaran, keuangan, procurement, dan supply chain untuk merumuskan skema penyesuaian harga jual yang adil namun kompetitif. Selain itu, dibahas pula rencana diversifikasi supplier dan opsi kontrak jangka panjang guna menekan risiko fluktuasi harga ekstrim. Hasil rekomendasi akan dipresentasikan kepada dewan direksi sebelum diimplementasikan secara bertahap mulai kuartal depan, dengan monitoring berkala untuk meminimalkan dampak terhadap margin keuntungan.', 'whats_new.php?id=3'),
(4, 'Pembaruan Sistem Tracking', '2025-06-29', 'img/pembaruan_sistem_tracking.png', 'Pembaruan sistem tracking barang kini mencakup modul real-time GPS dengan akurasi lokasi hingga 5 meter, dasbor analitik prediktif yang menampilkan tren pergerakan inventaris, serta antarmuka responsif untuk perangkat mobile dan tablet. Fitur notifikasi instan memungkinkan tim gudang dan logistik menerima peringatan sejak dini jika terdeteksi anomali-seperti keterlambatan pengiriman atau perubahan rute tak terduga. Implementasi tahap pertama telah diuji coba di gudang pusat, menghasilkan pengurangan waktu pencarian barang hingga 25% dan peningkatan akurasi data stok sebesar 98%. Ekspansi ke cabang-cabang regional akan diselesaikan dalam waktu tiga bulan, bersamaan dengan pelatihan pengguna dan penyusunan SOP baru.', 'whats_new.php?id=4'),
(5, 'Peningkatan Fasilitas Gudang', '2025-06-29', 'img/peningkatan_gudang.png', 'Proyek renovasi fasilitas gudang mencakup instalasi sistem rak otomatis (AS/RS) terbaru yang memanfaatkan teknologi robotik untuk pengambilan dan penempatan barang secara presisi. Area penyimpanan kini dilengkapi kontrol suhu pintar dan sistem ventilasi terintegrasi untuk menjaga kondisi ideal bagi berbagai jenis produk-mulai dari bahan kimia hingga barang elektronik sensitif. Optimalisasi layout telah mengikuti prinsip lean management, meminimalkan jarak tempuh forklift dan mempercepat alur inbound-outbound. Dengan kapasitas meningkat hingga 40%, protokol keamanan modern, dan sistem monitoring 24/7, diharapkan tingkat kehilangan dan kerusakan barang dapat ditekan di bawah 1%.', 'whats_new.php?id=5'),
(6, 'Integrasi Aplikasi Mobile', '2025-07-01', 'img/integrasi_mobile.png', 'Aplikasi mobile terbaru telah diluncurkan dengan fitur lengkap: pelaporan harian lokasi kerja dilengkapi foto dan tanda tangan elektronik, notifikasi push untuk tugas mendesak, serta dashboard ringkas yang menampilkan KPI harian dan progres target. Mode offline memungkinkan pengguna bekerja di area tanpa sinyal, dengan data tersinkronisasi otomatis begitu koneksi kembali terhubung. Integrasi API real-time ke sistem ERP perusahaan memastikan bahwa setiap laporan lapangan tercatat dalam modul keuangan dan logistik tanpa delay. Uji coba internal menunjukkan peningkatan efisiensi pelaporan hingga 50% dan tingkat adopsi karyawan mencapai 90% dalam minggu pertama penggunaan.', 'whats_new.php?id=6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sisa_cuti`
--

CREATE TABLE `sisa_cuti` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `total_cuti` int(11) DEFAULT 12,
  `cuti_terpakai` int(11) DEFAULT 0,
  `cuti_sisa` int(11) GENERATED ALWAYS AS (`total_cuti` - `cuti_terpakai`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sisa_cuti`
--

INSERT INTO `sisa_cuti` (`id`, `user_id`, `tahun`, `total_cuti`, `cuti_terpakai`) VALUES
(1, 8, '2025', 12, 0),
(2, 6, '2025', 12, 0),
(3, 9, '2025', 12, 0),
(4, 10, '2025', 12, 5),
(5, 7, '2025', 12, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `password`, `email`, `phone`, `photo_url`, `bio`, `created_at`) VALUES
(1, 'Alice Putri', 'HR', '12345', 'alice.putri@nagahtam.co.id', '+62 812-3456-7890', 'img/nami.jpeg', 'Bertugas mengelola seluruh administrasi karyawan termasuk persetujuan cuti, pemberian hak cuti, serta membaca dan menindaklanjuti laporan karyawan.', '2025-05-01 12:15:16'),
(2, 'Budi Santoso', 'Leader', '12345', 'budi.santoso@nagahtam.co.id', '+62 813-9876-5432', 'img/zoro.jpeg', 'Bertugas memberikan laporan pekerjaan per satu shift, serta memantau dan mengarahkan operator di lapangan agar pekerjaan berjalan sesuai target.', '2025-05-01 12:15:16'),
(3, 'Sanji', 'Leader', '12345', 'sanji@nagahtam.co.id', '+62 813-9876-5432', 'img/sanji.jpeg', 'Bertugas memberikan laporan pekerjaan per satu shift, serta memantau dan mengarahkan operator di lapangan agar pekerjaan berjalan sesuai target.', '2025-05-01 12:15:16'),
(4, 'Sutoyo dono', 'Manajer', 'sutoyo123', 'sutoyo@nagahtam.co.id', '+62 812-1234-5678', 'img/sutoyo.jpg', 'Bertanggung jawab atas keseluruhan operasional perusahaan dan pengambilan keputusan strategis di semua divisi.', '2025-05-01 22:41:16'),
(6, 'Ahmad Yusuf', 'Karyawan', 'karyawan123', 'ahmad.yusuf@nagahtam.co.id', '+62 812-3456-7890', 'img/ahmad_yusuf.jpg', 'Staf HR yang berfokus pada administrasi dan pengelolaan karyawan.', '2025-05-01 23:20:02'),
(7, 'Wanda', 'Karyawan', 'karyawan123', 'wanda@nagahtam.co.id', '+62 813-9876-5432', 'img/wanda.jpg', 'Supervisor yang memimpin tim dengan orientasi hasil dan efisiensi operasional.', '2025-05-01 23:20:02'),
(8, 'Agus', 'Karyawan', 'karyawan123', 'agus@nagahtam.co.id', '+62 813-9876-5432', 'img/budi.jpg', 'Operator yang mengawasi proses produksi dan memastikan kualitas barang yang dihasilkan.', '2025-05-01 23:20:02'),
(9, 'Lina Marlina', 'Karyawan', 'karyawan123', 'lina.marlina@nagahtam.co.id', '+62 812-1234-5678', 'img/lina.jpg', 'Manager yang memimpin divisi dengan fokus pada strategi dan pengembangan tim.', '2025-05-01 23:20:02'),
(10, 'Rudi Hartanto', 'Karyawan', 'karyawan123', 'rudi.hartono@nagahtam.co.id', '+62 813-5678-9012', 'img/rudi.jpg', 'Staf gudang yang bertanggung jawab atas pengelolaan stok dan pengiriman barang.', '2025-05-01 23:20:02');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cuti_logs`
--
ALTER TABLE `cuti_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuti_request_id` (`cuti_request_id`),
  ADD KEY `oleh_user_id` (`oleh_user_id`);

--
-- Indeks untuk tabel `cuti_requests`
--
ALTER TABLE `cuti_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `disetujui_oleh` (`disetujui_oleh`);

--
-- Indeks untuk tabel `laporan_kerja`
--
ALTER TABLE `laporan_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sisa_cuti`
--
ALTER TABLE `sisa_cuti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`tahun`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cuti_logs`
--
ALTER TABLE `cuti_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `cuti_requests`
--
ALTER TABLE `cuti_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `laporan_kerja`
--
ALTER TABLE `laporan_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `sisa_cuti`
--
ALTER TABLE `sisa_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cuti_logs`
--
ALTER TABLE `cuti_logs`
  ADD CONSTRAINT `cuti_logs_ibfk_1` FOREIGN KEY (`cuti_request_id`) REFERENCES `cuti_requests` (`id`),
  ADD CONSTRAINT `cuti_logs_ibfk_2` FOREIGN KEY (`oleh_user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `cuti_requests`
--
ALTER TABLE `cuti_requests`
  ADD CONSTRAINT `cuti_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cuti_requests_ibfk_2` FOREIGN KEY (`disetujui_oleh`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `sisa_cuti`
--
ALTER TABLE `sisa_cuti`
  ADD CONSTRAINT `sisa_cuti_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
