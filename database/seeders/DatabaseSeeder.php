<?php
namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\News;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Alice Putri',
            'role' => 'HR',
            'email' => 'alice.putri@nagahtam.co.id',
            'phone' => '08123456789',
            'password' => '12345',
            'photo_url'=> 'img/nami.jpeg',
            'bio' => 'Bertugas mengelola seluruh administrasi karyawan termasuk persetujuan cuti, pemberian hak cuti, serta membaca dan menindaklanjuti laporakaryawan.',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'role' => 'Leader',
            'email' => 'budi.santoso@nagahtam.co.id',
            'phone' => '08123456780',
            'password' => '12345',
            'photo_url'=> 'img/zoro.jpeg',
            'bio' => 'Bertugas memberikan laporan pekerjaan per satu shift, serta memantau dan mengarahkan operator di lapangan agar pekerjaan berjalan sesuai target.',
        ]);

        User::create([
            'name' => 'Sanji',
            'role' => 'Leader',
            'email' => 'sanji@nagahtam.co.id',
            'phone' => '08123456781',
            'password' => '12345',
            'photo_url'=> 'img/sanji.jpeg',
            'bio' => 'Bertugas memberikan laporan pekerjaan per satu shift, serta memantau dan mengarahkan operator di lapangan agar pekerjaan berjalan sesuai target.',
        ]);

        User::create([
            'name' => 'Sutoyo Dono',
            'role' => 'Manajer',
            'email' => 'sutoyo@nagahtam.co.id',
            'phone' => '08123456782',
            'password' => 'sutoyo123',
            'photo_url'=> 'img/sutoyo.jpeg',
            'bio' => 'Bertanggung jawab atas keseluruhan operasional perusahaan dan pengambilan keputusan strategis di semua divisi.',
        ]);

        User::create([
            'name' => 'Ahmad Yusuf',
            'role' => 'Karyawan',
            'email' => 'ahmad.yusuf@nagahtam.co.id',
            'phone' => '08123456783',
            'password' => 'karyawan123',
            'photo_url'=> 'img/ahmad_yusuf.jpg',
            'bio' => 'Staf HR yang berfokus pada administrasi dan pengelolaan karyawan.',
        ]);

        User::create([
            'name' => 'Wanda',
            'role' => 'Karyawan',
            'email' => 'wanda@nagahtam.co.id',
            'phone' => '08123456784',
            'password' => 'karyawan123',
            'photo_url'=> 'img/wanda.jpg',
            'bio' => 'Supervisor yang memimpin tim dengan orientasi hasil dan efisiensi operasional.',
        ]);

        User::create([
            'name' => 'Agus',
            'role' => 'Karyawan',
            'email' => 'agus@nagahtam.co.id',
            'phone' => '08123456785',
            'password' => 'karyawan123',
            'photo_url'=> 'img/budi.jpg',
            'bio' => 'Operator yang mengawasi proses produksi dan memastikan kualitas barang yang dihasilkan.',
        ]);

        User::create([
            'name' => 'Lina Marlina',
            'role' => 'Karyawan',
            'email' => 'lina.marlina@nagahtam.co.id',
            'phone' => '08123456786',
            'password' => 'karyawan123',
            'photo_url'=> 'img/lina.jpg',
            'bio' => 'Manager yang memimpin divisi dengan fokus pada strategi dan pengembangan tim.',
        ]);

        User::create([
            'name' => 'Rudi Hartono',
            'role' => 'Karyawan',
            'email' => 'rudi.hartono@nagahtam.co.id',
            'phone' => '08123456771',
            'password' => 'karyawan123',
            'photo_url'=> 'img/rudi.jpg',
            'bio' => 'Staf gudang yang bertanggung jawab atas pengelolaan stok dan pengiriman barang.',
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
            'description' => 'Sebagai bagian dari upaya membangun budaya meritokrasi, perusahaan telah memberikan promosi jabatan kepada karyawan terpilih yang menunjukkan prestasi luar biasa dalam proyek strategis dan pengembangan tim. Setiap kandidat dinilai berdasarkan pencapaian KPI, kualitas kepemimpinan, serta kontribusi inovatif dalam proses kerja-mulai dari efisiensi biaya hingga peningkatan kepuasan pelanggan. Upacara serah terima jabatan akan diselenggarakan dalam bentuk webinar interaktif, di mana para penerima promosi akan berbagi wawasan dan rencana aksi mereka untuk semester mendatang. Dokumen resmi yang memuat daftar nama, jabatan baru, dan uraian tanggung jawab terbaru dapat diunduh dari portal HR di menu Pengumuman.',
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
            'description' => 'Aplikasi mobile terbaru telah diluncurkan dengan fitur lengkap: pelaporan harian lokasi kerja dilengkapi foto dan tanda tangan elektronik, notifikasi push untuk tugas mendesak, serta dashboard ringkas yang menampilkan KPI harian dan progres target. Mode offline memungkinkan pengguna bekerja di area tanpa sinyal, dengan data tersinkronisasi otomatis begitu koneksi kembali terhubung. Integrasi API real-time ke sistem ERP perusahaan memastikan bahwa setiap laporan lapangan tercatat dalam modul keuangan dan logistik tanpa delay. Uji coba internal menunjukkan peningkatan efisiensi pelaporan hingga 50% dan tingkat adopsi karyawan mencapai 90% dalam minggu pertama penggunaan.',
            'link' => 'Null',
        ]);
    }
}