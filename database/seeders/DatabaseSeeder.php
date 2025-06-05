<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SisaCuti;
use App\Models\News;
use App\Models\CutiRequest;
use App\Models\CutiLogs;
use App\Models\LaporanKerja;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data untuk semua user
        $userData = [
            [
                'name'             => 'Alice Putri',
                'role'             => 'Admin',
                'email'            => 'alice.putri@nagahytam.co.id',
                'phone'            => '+62 812-3456-7890',
                'password'         => '12345',
                'photo_url'        => 'img/nami.jpeg',
                'bio'              => 'Mengelola administrasi karyawan.',
                'alamat'           => 'Jl. Merdeka No. 10, Jakarta Pusat',
                'joined_at'        => '2018-01-15',
                'education'        => 'SI Manajemen, Universitas Indonesia',
                'department'       => 'HR',
                'level'            => 'Senior',
                'job_descriptions' => 'Rekrutmen dan seleksi karyawan, Pengelolaan data karyawan, Pelatihan dan onboarding',
                'skills'           => 'Komunikasi, Microsoft Excel, Manajemen SDM',
                'achievements'     => 'Employee of the Year 2020, Penyusunan SOP HR'
            ],
            // ... (data user lain, tidak diubah, tetap rapi seperti di atas)
        ];

        foreach ($userData as $data) {
            // Ambil tahun dari joined_at atau tahun saat ini
            $joined_at = $data['joined_at'] ?? now();
            $year = Carbon::parse($joined_at)->format('Y');
            $prefix = 'NHSA';

            // Hitung jumlah karyawan yang sudah ada untuk tahun ini
            $count = User::where('id_karyawan', 'like', $prefix . $year . '%')->count() + 1;

            // Buat nomor urut dengan format 3 digit (misal, 001)
            $nomorUrut = str_pad($count, 3, '0', STR_PAD_LEFT);

            // Gabungkan untuk membentuk id_karyawan
            $data['id_karyawan'] = $prefix . $year . $nomorUrut;

            // Hash password
            $data['password'] = Hash::make($data['password']);

            // Simpan data user
            $user = User::create($data);

            // Buat entri sisa cuti default untuk user baru
            SisaCuti::create([
                'user_id'       => $user->id,
                'tahun'         => 2025,
                'total_cuti'    => 12,
                'cuti_terpakai' => 0,
                'cuti_sisa'     => 12
            ]);
        }

        // Data untuk News
        News::create([
            'date'        => '2025-06-29',
            'title'       => 'Pengumuman Libur Nasional Idul Adha',
            'image_url'   => 'img/libur_idul_adha.png',
            'description' => '<p>Sehubungan dengan Hari Raya Idul Adha 1446 H, seluruh aktivitas operasional gudang akan diliburkan pada tanggal <strong>8-9 Juli 2025</strong>. Kami mengimbau kepada seluruh operator untuk memastikan bahwa proses sortir, pengepakan, dan pengiriman barang telah diselesaikan sebelum tanggal tersebut. Koordinasikan dengan supervisor masing-masing untuk memastikan tidak ada barang tertunda di area inbound maupun outbound. Pastikan juga seluruh peralatan kerja telah diamankan dan area kerja dalam kondisi rapi sebelum libur dimulai.</p>
<p>Operasional gudang akan kembali berjalan normal pada <strong>10 Juli 2025</strong>. Diharapkan seluruh karyawan dapat hadir tepat waktu sesuai jadwal shift yang berlaku. Jika terdapat kebutuhan mendesak selama masa libur, silakan hubungi tim HR atau supervisor melalui kontak darurat yang telah disediakan. Selamat merayakan Idul Adha bersama keluarga, semoga kita semua diberikan kesehatan dan keselamatan.</p>',
            'link'        => 'Null'
        ]);

        News::create([
            'date'        => '2025-06-29',
            'title'       => 'Pemberitahuan Maintenance Gudang',
            'image_url'   => 'img/maintenance_gudang.png',
            'description' => 'Akan dilakukan maintenance sistem rak otomatis dan pengecekan alat berat pada 15 Juli 2025 mulai pukul 08.00 hingga 16.00 WIB. Selama proses maintenance, akses ke area penyimpanan utama dibatasi. Operator diharapkan mengikuti instruksi supervisor dan menjaga keselamatan kerja.',
            'link'        => 'Null'
        ]);

        News::create([
            'date'        => '2025-06-29',
            'title'       => 'Sosialisasi SOP Baru Pengiriman',
            'image_url'   => 'img/sop_pengiriman.png',
            'description' => 'Mulai 1 Juli 2025, berlaku SOP baru untuk proses pengiriman barang keluar gudang. Setiap operator wajib melakukan pengecekan barcode dan dokumentasi foto sebelum barang keluar. Pelatihan singkat akan diadakan pada 28 Juni 2025 di ruang meeting lantai 2.',
            'link'        => 'Null'
        ]);

        News::create([
            'date'        => '2025-06-29',
            'title'       => 'Pemberitahuan Pengecekan Alat Pemadam Kebakaran',
            'image_url'   => 'img/pengecekan_apar.png',
            'description' => 'Akan dilakukan pengecekan dan pengisian ulang alat pemadam kebakaran (APAR) di seluruh area gudang pada 14 Juli 2025 pukul 09.00-11.00 WIB. Seluruh operator diharapkan tidak memindahkan APAR dari tempat semula dan memberikan akses kepada tim teknisi. Pastikan jalur evakuasi tetap bersih selama proses berlangsung.',
            'link'        => 'Null'
        ]);

        News::create([
            'date'        => '2025-06-29',
            'title'       => 'Pengumuman Update Data Shift Otomatis',
            'image_url'   => 'img/update_shift_otomatis.png',
            'description' => 'Mulai 1 Agustus 2025, seluruh data shift operator akan diperbarui secara otomatis melalui sistem. Operator dapat melihat jadwal dan riwayat shift masing-masing di menu Data Shift. Jika ada ketidaksesuaian jadwal, segera laporkan ke supervisor untuk penyesuaian.',
            'link'        => 'Null'
        ]);

        News::create([
            'date'        => '2025-06-29',
            'title'       => 'Pengingat Penggunaan Alat Pelindung Diri (APD)',
            'image_url'   => 'img/apd_gudang.png',
            'description' => 'Demi keselamatan kerja, seluruh operator diwajibkan menggunakan APD lengkap (rompi, helm, dan sepatu safety) selama berada di area gudang. Pengawasan akan dilakukan secara berkala oleh tim K3. Pelanggaran akan dikenakan sanksi sesuai aturan perusahaan.',
            'link'        => 'Null'
        ]);

        // Data untuk CutiRequest
        CutiRequest::create([
            'user_id'           => 7,
            'tanggal_pengajuan' => '2025-05-04',
            'tanggal_mulai'     => '2025-05-05',
            'tanggal_selesai'   => '2025-05-10',
            'lama_cuti'         => 5,
            'alasan'            => "kakek sakit\r\n",
            'status'            => 'Disetujui',
            'tanggal_disetujui' => '2025-05-04',
            'catatan_hr'        => null,
            'created_at'        => '2025-05-04 22:49:44',
            'updated_at'        => '2025-05-04 22:50:06'
        ]);

        CutiRequest::create([
            'user_id'           => 9,
            'tanggal_pengajuan' => '2025-05-05',
            'tanggal_mulai'     => '2025-05-06',
            'tanggal_selesai'   => '2025-05-10',
            'lama_cuti'         => 4,
            'alasan'            => "keluarga sakit\r\n",
            'status'            => 'Disetujui',
            'tanggal_disetujui' => '2025-05-05',
            'catatan_hr'        => null,
            'created_at'        => '2025-05-05 02:15:06',
            'updated_at'        => '2025-05-05 04:22:41'
        ]);

        // Data untuk CutiLogs
        CutiLogs::create([
            'cuti_request_id' => 1,
            'aksi'            => 'Dibuat',
            'oleh_user_id'    => 7,
            'keterangan'      => 'Pengajuan dibuat'
        ]);

        CutiLogs::create([
            'cuti_request_id' => 2,
            'aksi'            => 'Disetujui',
            'oleh_user_id'    => 9,
            'keterangan'      => 'Diterima oleh HR'
        ]);

        // Data untuk LaporanKerja
        LaporanKerja::create([
            'tanggal'   => '2025-05-21',
            'nama'      => 'Froni',
            'divisi'    => 'HR specialist',
            'deskripsi' => 'target sudah tercapai, gudang sudah mengeluarkan barang sebanyak 250 unit'
        ]);

        LaporanKerja::create([
            'tanggal'   => '2025-05-05',
            'nama'      => 'Froni Wahyudi',
            'divisi'    => 'Operator Gudang',
            'deskripsi' => "barang sudah keluar 300 unit\r\n"
        ]);

        // Panggil seeder lain
        $this->call([
            ResiSeeder::class,
            ResiItemSeeder::class,
            ItemChecklistSeeder::class,
            ShiftSeeder::class
        ]);
    }
}
