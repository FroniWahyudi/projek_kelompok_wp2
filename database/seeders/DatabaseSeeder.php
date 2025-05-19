<?php
namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SisaCuti;
use App\Models\User;
use App\Models\News;
use App\Models\CutiRequest;
use App\Models\CutiLogs;
use App\Models\LaporanKerja;

use function Symfony\Component\String\s;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
          User::create([
            'name' => 'Alice Putri',
            'role' => 'Admin',
            'email' => 'alice.putri@nagahtam.co.id',
            'phone' => '08123456789',
            'password' => '12345',
            'photo_url'=> 'img/nami.jpeg',
            'bio' => 'Bertugas mengelola seluruh administrasi Operator termasuk persetujuan cuti, pemberian hak cuti, serta membaca dan menindaklanjuti laporaOperator.',
            'alamat' => 'Jl. Raya No. 1, Jakarta',
            'joined_at' => '2025-01-01',
            'education' => 'S1 Manajemen Sumber Daya Manusia',
            'department' => 'HR',
            'level' => 'Senior',
            'job_descriptions' => 'Rekrutmen dan seleksi Operator, Pengelolaan data Operator, Pelatihan dan onboarding.',
            'skills' => 'Komunikasi, Microsoft Excel, Manajemen SDM',
            'achievements' => 'Penghargaan Operator Terbaik 2024, Sertifikasi Manajemen SDM'
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'role' => 'Leader',
            'email' => 'budi.santoso@nagahtam.co.id',
            'phone' => '08123456780',
            'password' => '12345',
            'photo_url'=> 'img/zoro.jpeg',
            'bio' => 'Bertugas memberikan laporan pekerjaan per satu shift, serta memantau dan mengarahkan operator di lapangan agar pekerjaan berjalan sesuai target.',
            'alamat' => 'Jl. Industri No. 2, Bekasi',
            'joined_at' => '2024-08-15',
            'education' => 'S1 Teknik Industri',
            'department' => 'Produksi',
            'level' => 'Menengah',
            'job_descriptions' => 'Koordinasi tim shift, Monitoring target produksi, Pelaporan harian.',
            'skills' => 'Kepemimpinan, Analisis Data, Komunikasi',
            'achievements' => 'Ketua Tim Produksi Terbaik 2023'
        ]);

        User::create([
            'name' => 'Sanji',
            'role' => 'Leader',
            'email' => 'sanji@nagahtam.co.id',
            'phone' => '08123456781',
            'password' => '12345',
            'photo_url'=> 'img/sanji.jpeg',
            'bio' => 'Bertugas memberikan laporan pekerjaan per satu shift, serta memantau dan mengarahkan operator di lapangan agar pekerjaan berjalan sesuai target.',
            'alamat' => 'Jl. Pelabuhan No. 5, Surabaya',
            'joined_at' => '2024-07-01',
            'education' => 'D3 Manufaktur',
            'department' => 'Produksi',
            'level' => 'Menengah',
            'job_descriptions' => 'Pengawasan mesin produksi, Koordinasi teknisi, Pelaporan kualitas harian.',
            'skills' => 'Manajemen Waktu, Problem Solving, Mesin Industri',
            'achievements' => 'Peningkatan Efisiensi Produksi 15%'
        ]);

        User::create([
            'name' => 'Sutoyo Dono',
            'role' => 'Manajer',
            'email' => 'sutoyo@nagahtam.co.id',
            'phone' => '08123456782',
            'password' => 'sutoyo123',
            'photo_url'=> 'img/sutoyo.jpeg',
            'bio' => 'Bertanggung jawab atas keseluruhan operasional perusahaan dan pengambilan keputusan strategis di semua divisi.',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'joined_at' => '2020-01-10',
            'education' => 'S2 Administrasi Bisnis',
            'department' => 'Manajemen',
            'level' => 'Eksekutif',
            'job_descriptions' => 'Pengambilan keputusan, Evaluasi kinerja divisi, Penyusunan strategi perusahaan.',
            'skills' => 'Analisis Strategis, Manajemen Risiko, Kepemimpinan',
            'achievements' => 'Peningkatan ROI Tahunan, Pemimpin Inspiratif 2022'
        ]);

        User::create([
            'name' => 'Ahmad Yusuf',
            'role' => 'Operator',
            'email' => 'ahmad.yusuf@nagahtam.co.id',
            'phone' => '08123456783',
            'password' => '12345',
            'photo_url'=> 'img/ahmad_yusuf.jpg',
            'bio' => 'Staf HR yang berfokus pada administrasi dan pengelolaan Operator.',
            'alamat' => 'Jl. HRD No. 8, Tangerang',
            'joined_at' => '2023-05-20',
            'education' => 'S1 Psikologi',
            'department' => 'HR',
            'level' => 'Junior',
            'job_descriptions' => 'Input data Operator, Administrasi cuti, Arsip dokumen SDM.',
            'skills' => 'Filing, Administrasi, Komunikasi',
            'achievements' => 'Operator Teladan Bulan Februari 2024'
        ]);

        User::create([
            'name' => 'Wanda',
            'role' => 'Operator',
            'email' => 'wanda@nagahtam.co.id',
            'phone' => '08123456784',
            'password' => 'Operator',
            'photo_url'=> 'img/wanda.jpg',
            'bio' => 'Supervisor yang memimpin tim dengan orientasi hasil dan efisiensi operasional.',
            'alamat' => 'Jl. Mekar No. 12, Bandung',
            'joined_at' => '2022-11-01',
            'education' => 'S1 Teknik Mesin',
            'department' => 'Operasional',
            'level' => 'Senior',
            'job_descriptions' => 'Koordinasi tim operasional, Monitoring peralatan, Laporan hasil kerja.',
            'skills' => 'Supervisi, Teknik Produksi, Microsoft Excel',
            'achievements' => 'Peningkatan Output Bulanan 2023'
        ]);

        User::create([
            'name' => 'Agus',
            'role' => 'Operator',
            'email' => 'agus@nagahtam.co.id',
            'phone' => '08123456785',
            'password' => 'karyawan123',
            'photo_url'=> 'img/budi.jpg',
            'bio' => 'Operator yang mengawasi proses produksi dan memastikan kualitas barang yang dihasilkan.',
            'alamat' => 'Jl. Produksi No. 3, Karawang',
            'joined_at' => '2023-02-17',
            'education' => 'SMK Otomasi Industri',
            'department' => 'Produksi',
            'level' => 'Junior',
            'job_descriptions' => 'Pengoperasian mesin, Pemeriksaan kualitas, Pemeliharaan alat.',
            'skills' => 'Operator Mesin, QC, Maintenance',
            'achievements' => 'Zero Defect Award 2024'
        ]);

        User::create([
            'name' => 'Lina Marlina',
            'role' => 'Operator',
            'email' => 'lina.marlina@nagahtam.co.id',
            'phone' => '08123456786',
            'password' => 'Operator',
            'photo_url'=> 'img/lina.jpg',
            'bio' => 'Manager yang memimpin divisi dengan fokus pada strategi dan pengembangan tim.',
            'alamat' => 'Jl. Sentosa No. 4, Depok',
            'joined_at' => '2021-03-30',
            'education' => 'S1 Administrasi Publik',
            'department' => 'Manajemen',
            'level' => 'Senior',
            'job_descriptions' => 'Perencanaan strategi divisi, Evaluasi performa tim, Pengembangan sumber daya.',
            'skills' => 'Perencanaan, Manajemen Tim, Coaching',
            'achievements' => 'Manager Inspiratif 2023'
        ]);

        User::create([
            'name' => 'Rudi Hartono',
            'role' => 'Operator',
            'email' => 'rudi.hartono@nagahtam.co.id',
            'phone' => '08123456771',
            'password' => 'Operator',
            'photo_url'=> 'img/rudi.jpg',
            'bio' => 'Staf gudang yang bertanggung jawab atas pengelolaan stok dan pengiriman barang.',
            'alamat' => 'Jl. Gudang No. 9, Bogor',
            'joined_at' => '2022-01-05',
            'education' => 'SMA',
            'department' => 'Gudang',
            'level' => 'Junior',
            'job_descriptions' => 'Stok barang, Pengiriman, Pelaporan gudang.',
            'skills' => 'Stok Opname, Pengemasan, Ketelitian',
            'achievements' => 'Staf Gudang Teladan 2023'
        ]);
        User::create([
            'name' => 'Fahri',
            'role' => 'Admin',
            'email' => 'fahri@nagahtam.co.id',
            'phone' => '08123456772',
            'password' => '12345',
            'photo_url'=> 'img/fahri.jpg',
            'bio' => 'Bertugas mengelola seluruh administrasi Operator termasuk persetujuan cuti, pemberian hak cuti, serta membaca dan menindaklanjuti laporaOperator.',
            'alamat' => 'Jl. Raya No. 1, Jakarta',
            'joined_at' => '2025-01-01',
            'education' => 'S1 Manajemen Sumber Daya Manusia',
            'department' => 'HR',
            'level' => 'Senior',
            'job_descriptions' => 'Rekrutmen dan seleksi Operator, Pengelolaan data Operator, Pelatihan dan onboarding.',
            'skills' => 'Komunikasi, Microsoft Excel, Manajemen SDM',
            'achievements' => 'Penghargaan Operator Terbaik 2024, Sertifikasi Manajemen SDM',
        ]);

        News::create([
            'date' => '2025-06-29',
            'title' => 'Pengembangan Produk Inovatif',
            'image_url' => 'img/karyawan_inovasi.png',
            'description' => 'Tim R&D kami telah menyelesaikan serangkaian pengujian ekstensif terhadap prototipe produk inovatif yang menggabungkan material komposit ramah lingkungan dan teknologi penghematan energi terkini. Hasil uji laboratorium menunjukkan peningkatan performa hingga 30% serta pengurangan konsumsi energi hampir 20%, sekaligus menjaga stabilitas suhu operasional di bawah ambang batas keamanan. Fase uji lapangan kini melibatkan mitra strategis dan pelanggan pilot, dengan target validasi kualitas dan skalabilitas produksi massal dalam dua bulan ke depan. Rencana peluncuran komersial dijadwalkan pada kuartal berikutnya, lengkap dengan dukungan layanan purna jual dan pelatihan teknis untuk memastikan adopsi optimal di berbagai sektor industri.',
            'link' => 'Null',
        ]);
        
        News::create([
            'date' => '2025-06-29',
            'title' => 'Promosi Jabatan',
            'image_url' => 'img/naik_jabatan.png',
            'description' => 'Sebagai bagian dari upaya membangun budaya meritokrasi, perusahaan telah memberikan promosi jabatan kepada Operator terpilih yang menunjukkan prestasi luar biasa dalam proyek strategis dan pengembangan tim. Setiap kandidat dinilai berdasarkan pencapaian KPI, kualitas kepemimpinan, serta kontribusi inovatif dalam proses kerja-mulai dari efisiensi biaya hingga peningkatan kepuasan pelanggan. Upacara serah terima jabatan akan diselenggarakan dalam bentuk webinar interaktif, di mana para penerima promosi akan berbagi wawasan dan rencana aksi mereka untuk semester mendatang. Dokumen resmi yang memuat daftar nama, jabatan baru, dan uraian tanggung jawab terbaru dapat diunduh dari portal HR di menu Pengumuman.',
            'link' => 'Null',
        ]);

        News::create([
            'date' => '2025-06-29',
            'title' => 'Rapat Strategi Bisnis',
            'image_url' => 'img/rapat_kenaikan_harga.png',
            'description' => 'Dalam rapat strategi bisnis lintas divisi, pimpinan perusahaan memimpin diskusi mendalam mengenai dinamika harga bahan baku global yang berdampak langsung pada struktur biaya produksi. Pertemuan ini melibatkan tim pemasaran, keuangan, procurement, dan supply chain untuk merumuskan skema penyesuaian harga jual yang adil namun kompetitif. Selain itu, dibahas pula rencana diversifikasi supplier dan opsi kontrak jangka panjang guna menekan risiko fluktuasi harga ekstrim. Hasil rekomendasi akan dipresentasikan kepada dewan direksi sebelum diimplementasikan secara bertahap mulai kuartal depan, dengan monitoring berkala untuk meminimalkan dampak terhadap margin keuntungan.',
            'link' => 'Null',
        ]);

        News::create([
            'date' => '2025-06-29',
            'title' => 'Pembaruan Sistem Tracking',
            'image_url' => 'img/pembaruan_sistem_tracking.png',
            'description' => 'Pembaruan sistem tracking barang kini mencakup modul real-time GPS dengan akurasi lokasi hingga 5 meter, dasbor analitik prediktif yang menampilkan tren pergerakan inventaris, serta antarmuka responsif untuk perangkat mobile dan tablet. Fitur notifikasi instan memungkinkan tim gudang dan logistik menerima peringatan sejak dini jika terdeteksi anomali-seperti keterlambatan pengiriman atau perubahan rute tak terduga. Implementasi tahap pertama telah diuji coba di gudang pusat, menghasilkan pengurangan waktu pencarian barang hingga 25% dan peningkatan akurasi data stok sebesar 98%. Ekspansi ke cabang-cabang regional akan diselesaikan dalam waktu tiga bulan, bersamaan dengan pelatihan pengguna dan penyusunan SOP baru.',
            'link' => 'Null',
        ]);

        News::create([
            'date' => '2025-06-29',
            'title' => 'Peningkatan Fasilitas Gudang',
            'image_url' => 'img/peningkatan_gudang.png',
            'description' => 'Proyek renovasi fasilitas gudang mencakup instalasi sistem rak otomatis (AS/RS) terbaru yang memanfaatkan teknologi robotik untuk pengambilan dan penempatan barang secara presisi. Area penyimpanan kini dilengkapi kontrol suhu pintar dan sistem ventilasi terintegrasi untuk menjaga kondisi ideal bagi berbagai jenis produk-mulai dari bahan kimia hingga barang elektronik sensitif. Optimalisasi layout telah mengikuti prinsip lean management, meminimalkan jarak tempuh forklift dan mempercepat alur inbound-outbound. Dengan kapasitas meningkat hingga 40%, protokol keamanan modern, dan sistem monitoring 24/7, diharapkan tingkat kehilangan dan kerusakan barang dapat ditekan di bawah 1%.',
            'link' => 'Null',
        ]);

        News::create([
            'date' => '2025-06-29',
            'title' => 'Integrasi Aplikasi Mobile',
            'image_url' => 'img/integrasi_mobile.png',
            'description' => 'Aplikasi mobile terbaru telah diluncurkan dengan fitur lengkap: pelaporan harian lokasi kerja dilengkapi foto dan tanda tangan elektronik, notifikasi push untuk tugas mendesak, serta dashboard ringkas yang menampilkan KPI harian dan progres target. Mode offline memungkinkan pengguna bekerja di area tanpa sinyal, dengan data tersinkronisasi otomatis begitu koneksi kembali terhubung. Integrasi API real-time ke sistem ERP perusahaan memastikan bahwa setiap laporan lapangan tercatat dalam modul keuangan dan logistik tanpa delay. Uji coba internal menunjukkan peningkatan efisiensi pelaporan hingga 50% dan tingkat adopsi Operator mencapai 90% dalam minggu pertama penggunaan.',
            'link' => 'Null',
        ]);

        CutiRequest::create([
            'user_id' => 7,
            'tanggal_pengajuan' => '2025-05-04',
            'tanggal_mulai' => '2025-05-05',
            'tanggal_selesai' => '2025-05-10',
            'lama_cuti' => 5,
            'alasan' => "kakek sakit\r\n",
            'status' => 'Disetujui',
            'tanggal_disetujui' => '2025-05-04',
            'catatan_hr' => null,
            'created_at' => '2025-05-04 22:49:44',
            'updated_at' => '2025-05-04 22:50:06',
        ]);

        CutiRequest::create([
            'user_id' => 9,
            'tanggal_pengajuan' => '2025-05-05',
            'tanggal_mulai' => '2025-05-06',
            'tanggal_selesai' => '2025-05-10',
            'lama_cuti' => 4,
            'alasan' => "keluarga sakit\r\n",
            'status' => 'Disetujui',
            'tanggal_disetujui' => '2025-05-05',
            'catatan_hr' => null,
            'created_at' => '2025-05-05 02:15:06',
            'updated_at' => '2025-05-05 04:22:41',
        ]);

        CutiLogs::create([
            'cuti_request_id' => 1,
            'aksi' => 'Dibuat',
            'oleh_user_id' => 7,
            'keterangan' => 'Pengajuan dibuat',
        ]);

        CutiLogs::create([
            'cuti_request_id' => 2,
            'aksi' => 'Disetujui',
            'oleh_user_id' => 9,
            'keterangan' => 'Diterima oleh HR',
        ]);

        SisaCuti::create([
            'user_id' => 5,
            'tahun' => 2025,
            'total_cuti' => 12,
            'cuti_terpakai' => 5,
            'cuti_sisa' => 7,
        ]);

        SisaCuti::create([
            'user_id' => 6,
            'tahun' => 2025,
            'total_cuti' => 12,
            'cuti_terpakai' => 4,
            'cuti_sisa' => 8,
        ]);

        SisaCuti::create([
            'user_id' => 7,
            'tahun' => 2025,
            'total_cuti' => 12,
            'cuti_terpakai' => 5,
            'cuti_sisa' => 7,
        ]);

        sisaCuti::create([
            'user_id' => 8,
            'tahun' => 2025,
            'total_cuti' => 12,
            'cuti_terpakai' => 4,
            'cuti_sisa' => 8,
        ]);
        
        SisaCuti::create([
            'user_id' => 9,
            'tahun' => 2025,
            'total_cuti' => 12,
            'cuti_terpakai' => 4,
            'cuti_sisa' => 8,
        ]);

        LaporanKerja::create([
            'tanggal' => '2025-05-21',
            'nama' => 'Froni ',
            'divisi' => 'HR specialist',
            'deskripsi' => 'target sudah tercapai ,gudang sudah mengeluarkan barang sebanyak 250 unit',
        ]);
        LaporanKerja::create([
            'tanggal' => '2025-05-05',
            'nama' => 'Froni Wahyudi',
            'divisi' => 'Operator Gudang',
            'deskripsi' => "barang sudah keluar 300 unit\r\n",
        ]);
        // cuti_logs Table
        /*DB::table('cuti_logs')->insert([
            ['cuti_request_id' => 2, 'aksi' => 'Dibuat', 'oleh_user_id' => 7, 'waktu' => '2025-05-04 22:49:44', 'keterangan' => 'Pengajuan dibuat'],
            ['cuti_request_id' => 2, 'aksi' => 'Disetujui', 'oleh_user_id' => 1, 'waktu' => '2025-05-04 22:50:06', 'keterangan' => 'Diterima oleh HR'],
            ['cuti_request_id' => 3, 'aksi' => 'Dibuat', 'oleh_user_id' => 10, 'waktu' => '2025-05-05 02:15:06', 'keterangan' => 'Pengajuan dibuat'],
            ['cuti_request_id' => 3, 'aksi' => 'Disetujui', 'oleh_user_id' => 1, 'waktu' => '2025-05-05 04:22:41', 'keterangan' => 'Diterima oleh HR'],
        ]);

        // laporan_kerja Table
        DB::table('laporan_kerja')->insert([
            ['tanggal' => '2025-05-21', 'nama' => 'Froni ', 'divisi' => 'HR specialist', 'deskripsi' => 'target sudah tercapai ,gudang sudah mengeluarkan barang sebanyak 250 unit', 'created_at' => '2025-05-02 12:12:42'],
            ['tanggal' => '2025-05-05', 'nama' => 'Froni Wahyudi', 'divisi' => 'Operator Gudang', 'deskripsi' => "barang sudah keluar 300 unit\r\n", 'created_at' => '2025-05-05 09:14:38'],
        ]);*/

    }
}