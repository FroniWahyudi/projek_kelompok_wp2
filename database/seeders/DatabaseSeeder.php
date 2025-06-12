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
        'name'             => 'Fadhillah Rudi Hartono',
        'role'             => 'Admin',
        'email'            => 'fadhillahrudi@nagahytam.co.id',
        'phone'            => '+62 812-3456-7890',
        'password'         => '12345678',
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
    [
        'name'             => 'Budi Santoso',
        'role'             => 'Leader',
        'email'            => 'budi.santoso@nagahytam.co.id',
        'phone'            => '+62 813-9876-5432',
        'password'         => '12345',
        'photo_url'        => 'img/zoro.jpeg',
        'bio'              => 'Memantau operator lapangan.',
        'alamat'           => 'Jl. Sudirman Kav. 12, Jakarta Selatan',
        'joined_at'        => '2019-03-10',
        'education'        => 'Teknik Industri, Institut Teknologi Bandung',
        'department'       => 'Operasional',
        'level'            => 'Intermediate',
        'job_descriptions' => 'Koordinasi tim lapangan, Laporan harian produksi',
        'skills'           => 'Leadership, Problem Solving, Safety Management',
        'achievements'     => 'Tim terbaik Q4 2021'
    ],
    [
        'name'             => 'Froni Wahyudi',
        'role'             => 'Leader',
        'email'            => 'froniwahyudi@nagahytam.co.id',
        'phone'            => '+62 813-9876-5432',
        'password'         => '12345678',
        'photo_url'        => 'img/froni.jpeg',
        'bio'              => 'Memantau operator lapangan.',
        'alamat'           => 'Jl. Pahlawan No. 3, Surabaya',
        'joined_at'        => '2020-07-22',
        'education'        => 'Teknik Mesin, Universitas Negeri Surabaya',
        'department'       => 'Operasional',
        'level'            => 'Intermediate',
        'job_descriptions' => 'Jadwal shift operator, Optimasi workflow produksi',
        'skills'           => 'Time Management, Maintenance Planning',
        'achievements'     => 'Pengurangan downtime 15%'
    ],
    [
        'name'             => 'Ahmad Fadillah Martin',
        'role'             => 'Manajer',
        'email'            => 'ahmadfadillahmartin@nagahytam.co.id',
        'phone'            => '+62 812-1234-5678',
        'password'         => '12345678',
        'photo_url'        => 'img/sutoyo.jpg',
        'bio'              => 'Memimpin pengambilan keputusan strategis perusahaan dan memastikan keberlanjutan operasional jangka panjang. Bertanggung jawab atas koordinasi lintas departemen untuk mencapai tujuan bisnis secara efektif.',
        'alamat'           => 'Jl. Diponegoro No. 20, Semarang',
        'joined_at'        => '2015-11-05',
        'education'        => 'Magister Manajemen, Universitas Gadjah Mada',
        'department'       => 'Manajemen',
        'level'            => 'Senior',
        'job_descriptions' => 'Perencanaan strategi perusahaan, Koordinasi antar-departemen',
        'skills'           => 'Strategic Planning, Negotiation',
        'achievements'     => 'Penghargaan Leader of the Year 2019'
    ],
    [
        'name'             => 'Putri Tanjung',
        'role'             => 'Admin',
        'email'            => 'putri.tanjung@nagahytam.co.id',
        'phone'            => '+62 813-4567-8901',
        'password'         => 'putri123',
        'photo_url'        => 'img/putri_tanjung.jpg',
        'bio'              => 'Mengelola administrasi dan koordinasi tim.',
        'alamat'           => 'Jl. Melati No. 12, Bandung',
        'joined_at'        => '2019-05-20',
        'education'        => 'Administrasi Bisnis, Universitas Padjadjaran',
        'department'       => 'Administrasi',
        'level'            => 'Senior',
        'job_descriptions' => 'Membuat laporan bulanan, Koordinasi dengan manajemen',
        'skills'           => 'Microsoft Office, Komunikasi, Manajemen Proyek',
        'achievements'     => 'Employee of the Month 2022'
    ],
    [
        'name'             => 'Ahmad Yusuf',
        'role'             => 'Operator',
        'email'            => 'ahmad.yusuf@nagahytam.co.id',
        'phone'            => '+62 812-3456-7890',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Bertanggung jawab proses sortir dan packing barang.',
        'alamat'           => 'Jl. Gajah Mada No. 15, Yogyakarta',
        'joined_at'        => '2021-02-18',
        'education'        => 'Administrasi Bisnis, UNDIP',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Sortir barang, Packing pesanan, Inventory checker',
        'skills'           => 'Ketelitian, Kecepatan, Barcode scanning',
        'achievements'     => 'Zero Error Packing 2022',
        'divisi'           => 'inbound'
    ],
    [
        'name'             => 'Wandi Kurnia',
        'role'             => 'Operator',
        'email'            => 'wandi.kurnia@nagahytam.co.id',
        'phone'            => '+62 813-9876-5432',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Menerima, sortir kualitas, dan packing kiriman.',
        'alamat'           => 'Jl. Pemuda No. 7, Bekasi',
        'joined_at'        => '2017-08-30',
        'education'        => 'Manaj. Operasional, UNPAD',
        'department'       => 'Gudang',
        'level'            => 'Senior',
        'job_descriptions' => 'Penerimaan barang, Sortir kualitas, Inventory checker',
        'skills'           => 'QC, Supervisi, Komunikasi',
        'achievements'     => 'Akurasi 99% 2021',
        'divisi'           => 'inbound'
    ],
    [
        'name'             => 'Muhammad Rifqi',
        'role'             => 'Operator',
        'email'            => 'muhammadrifqi@nagahytam.co.id',
        'phone'            => '+62 813-9876-5432',
        'password'         => '12345678',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Operator gudang: sortir, packing, tata rak.',
        'alamat'           => 'Jl. Raya Bogor No. 45, Depok',
        'joined_at'        => '2022-04-12',
        'education'        => 'Teknik Kimia, IST',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Packing barang, Tata rak',
        'skills'           => 'Organisasi, Machine Op',
        'achievements'     => 'Zero Defect April 2023',
        'divisi'           => 'inbound'
    ],
    [
        'name'             => 'Rian Marlino',
        'role'             => 'Operator',
        'email'            => 'rian.marlino@nagahytam.co.id',
        'phone'            => '+62 812-1234-5678',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Menjalankan sortir otomatis & manual.',
        'alamat'           => 'Jl. Sultan Iskandar No. 8, Medan',
        'joined_at'        => '2016-06-21',
        'education'        => 'S2 Manajemen, USU',
        'department'       => 'Gudang',
        'level'            => 'Senior',
        'job_descriptions' => 'Sortir otomatis, Maintenance, Inventory checker',
        'skills'           => 'Monitoring, Maintenance',
        'achievements'     => 'Divisi Terbaik 2022',
        'divisi'           => 'inbound'
    ],
    [
        'name'             => 'Rudi Hartanto',
        'role'             => 'Operator',
        'email'            => 'rudi.hartanto@nagahytam.co.id',
        'phone'            => '+62 813-5678-9012',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Cek inventori, packing, koordinasi kiriman.',
        'alamat'           => 'Jl. Bumi Raya No. 9, Palembang',
        'joined_at'        => '2019-09-14',
        'education'        => 'Logistik, UNSRI',
        'department'       => 'Gudang',
        'level'            => 'Intermediate',
        'job_descriptions' => 'Audit inventory, Packing, Koordinasi ekspedisi',
        'skills'           => 'Inventory Mgmt, Forklift',
        'achievements'     => 'On-Time Delivery 2021',
        'divisi'           => 'inbound'
    ],
    [
        'name'             => 'Andi Prasetyo',
        'role'             => 'Operator',
        'email'            => 'andi.prasetyo@nagahytam.co.id',
        'phone'            => '+62 811-0000-0001',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Sorting barang masuk dan penataan rak.',
        'alamat'           => 'Jl. Merpati No. 11, Bandung',
        'joined_at'        => '2020-01-05',
        'education'        => 'Manajemen, UNPAD',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Sortir, Penataan rak, Packing',
        'skills'           => 'Ketelitian, Kecepatan',
        'achievements'     => 'Best Sorter 2020',
        'divisi'           => 'inbound'
    ],
    [
        'name'             => 'Budi Hartono',
        'role'             => 'Operator',
        'email'            => 'budi.hartono@nagahytam.co.id',
        'phone'            => '+62 811-0000-0002',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Memproses packing dan labeling pesanan.',
        'alamat'           => 'Jl. Kenari No. 12, Jakarta Utara',
        'joined_at'        => '2018-03-10',
        'education'        => 'Logistik, UI',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Packing, Labeling, QC',
        'skills'           => 'Label Accuracy, Packing Speed',
        'achievements'     => 'Employee of Month Mar 2022',
        'divisi'           => 'inbound'
    ],
    [
        'name'             => 'Candra Wijaya',
        'role'             => 'Operator',
        'email'            => 'candra.wijaya@nagahytam.co.id',
        'phone'            => '+62 811-0000-0003',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Bertugas terima barang dan sortir kualitas.',
        'alamat'           => 'Jl. Kenanga No. 13, Surabaya',
        'joined_at'        => '2019-05-21',
        'education'        => 'Teknik Industri, ITS',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Penerimaan barang, Sortir QC',
        'skills'           => 'QC, Data Entry',
        'achievements'     => 'Zero Defect Jun 2023',
        'divisi'           => 'inbound'
    ],
    [
        'name'             => 'Dedi Saputra',
        'role'             => 'Operator',
        'email'            => 'dedi.saputra@nagahytam.co.id',
        'phone'            => '+62 811-0000-0004',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Melakukan packing & persiapan kirim.',
        'alamat'           => 'Jl. Pelita No. 14, Medan',
        'joined_at'        => '2020-07-15',
        'education'        => 'Logistik, USU',
        'department'       => 'Gudang',
        'level'            => 'Intermediate',
        'job_descriptions' => 'Packing, Koordinasi kirim',
        'skills'           => 'Logistik, Forklift',
        'achievements'     => 'Best Packer 2021',
        'divisi'           => 'inbound'
    ],
    [
        'name'             => 'Eko Prabowo',
        'role'             => 'Operator',
        'email'            => 'eko.prabowo@nagahytam.co.id',
        'phone'            => '+62 811-0000-0005',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Menata ulang rak dan inventory check.',
        'alamat'           => 'Jl. Mangga No. 15, Semarang',
        'joined_at'        => '2021-11-30',
        'education'        => 'Manajemen, UGM',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Rak organization, Inventory checker',
        'skills'           => 'Detail-oriented',
        'achievements'     => 'Inventory Hero 2023',
        'divisi'           => 'inbound'
    ],
    [
        'name'             => 'Fajar Nugroho',
        'role'             => 'Operator',
        'email'            => 'fajar.nugroho@nagahytam.co.id',
        'phone'            => '+62 811-0000-0006',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Supervisor packing shift malam.',
        'alamat'           => 'Jl. Anggrek No. 16, Bekasi',
        'joined_at'        => '2017-02-18',
        'education'        => 'Manajemen, UNPAD',
        'department'       => 'Gudang',
        'level'            => 'Senior',
        'job_descriptions' => 'Supervisi packing, QC',
        'skills'           => 'Leadership',
        'achievements'     => 'Night Shift Star',
        'divisi'           => 'outbound'
    ],
    [
        'name'             => 'Galih Santoso',
        'role'             => 'Operator',
        'email'            => 'galih.santoso@nagahytam.co.id',
        'phone'            => '+62 811-0000-0007',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Mengelola sortir manual dan mesin.',
        'alamat'           => 'Jl. Melur No. 17, Bandung',
        'joined_at'        => '2018-10-10',
        'education'        => 'Teknik Mesin, ITB',
        'department'       => 'Gudang',
        'level'            => 'Intermediate',
        'job_descriptions' => 'Sortir manual & mesin',
        'skills'           => 'Machine Ops',
        'achievements'     => 'Sort Master 2022',
        'divisi'           => 'outbound'
    ],
    [
        'name'             => 'Hadi Wijaya',
        'role'             => 'Operator',
        'email'            => 'hadi.wijaya@nagahytam.co.id',
        'phone'            => '+62 811-0000-0008',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Menangani return barang & QC ulang.',
        'alamat'           => 'Jl. Dahlia No. 18, Surabaya',
        'joined_at'        => '2019-12-01',
        'education'        => 'Teknik Industri, ITS',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Return processing, Re-QC',
        'skills'           => 'QC',
        'achievements'     => 'Return King 2022',
        'divisi'           => 'outbound'
    ],
    [
        'name'             => 'Iwan Setiawan',
        'role'             => 'Operator',
        'email'            => 'iwan.setiawan@nagahytam.co.id',
        'phone'            => '+62 811-0000-0009',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Koordinasi forklift & stoking rak.',
        'alamat'           => 'Jl. Flamboyan No. 19, Jakarta Timur',
        'joined_at'        => '2020-04-22',
        'education'        => 'Logistik, UI',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Forklift operation, Stoking',
        'skills'           => 'Forklift',
        'achievements'     => 'Forklift Ace 2023',
        'divisi'           => 'outbound'
    ],
    [
        'name'             => 'Joko Susilo',
        'role'             => 'Operator',
        'email'            => 'joko.susilo@nagahytam.co.id',
        'phone'            => '+62 811-0000-0010',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Mengemas barang besar & berat.',
        'alamat'           => 'Jl. Kenari No. 20, Palembang',
        'joined_at'        => '2021-08-05',
        'education'        => 'Teknik Mesin, UNSRI',
        'department'       => 'Gudang',
        'level'            => 'Intermediate',
        'job_descriptions' => 'Heavy item packing',
        'skills'           => 'Strength, Teamwork',
        'achievements'     => 'Heavy Lifter Award',
        'divisi'           => 'outbound'
    ],
    [
        'name'             => 'Krisna Aditya',
        'role'             => 'Operator',
        'email'            => 'krisna.aditya@nagahytam.co.id',
        'phone'            => '+62 811-0000-0011',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Packing kilat & drop-shipping.',
        'alamat'           => 'Jl. Bambu No. 21, Depok',
        'joined_at'        => '2022-02-14',
        'education'        => 'Manajemen, UNDIP',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Express packing',
        'skills'           => 'Speed Packing',
        'achievements'     => 'Flash Packer',
        'divisi'           => 'outbound'
    ],
    [
        'name'             => 'Lukman Hakim',
        'role'             => 'Operator',
        'email'            => 'lukman.hakim@nagahytam.co.id',
        'phone'            => '+62 811-0000-0012',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'QC akhir sebelum kirim.',
        'alamat'           => 'Jl. Cemara No. 22, Medan',
        'joined_at'        => '2018-06-18',
        'education'        => 'Manajemen, USU',
        'department'       => 'Gudang',
        'level'            => 'Senior',
        'job_descriptions' => 'Final QC',
        'skills'           => 'QC, Detail',
        'achievements'     => 'QC Champion',
        'divisi'           => 'outbound'
    ],
    [
        'name'             => 'Miko Pratama',
        'role'             => 'Operator',
        'email'            => 'miko.pratama@nagahytam.co.id',
        'phone'            => '+62 811-0000-0013',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Input data inventory & sortir.',
        'alamat'           => 'Jl. Anggrek No. 23, Yogyakarta',
        'joined_at'        => '2019-09-30',
        'education'        => 'Administrasi, UGM',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Data entry inventory, Sortir',
        'skills'           => 'MS Excel',
        'achievements'     => 'Data Star',
        'divisi'           => 'outbound'
    ],
    [
        'name'             => 'Novan Ryan',
        'role'             => 'Operator',
        'email'            => 'novan.ryan@nagahytam.co.id',
        'phone'            => '+62 811-0000-0014',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Menangani packing pesanan e-commerce.',
        'alamat'           => 'Jl. Melati No. 24, Bandung',
        'joined_at'        => '2020-11-11',
        'education'        => 'Logistik, UNPAD',
        'department'       => 'Gudang',
        'level'            => 'Intermediate',
        'job_descriptions' => 'E-commerce packing',
        'skills'           => 'Speed & Care',
        'achievements'     => 'E-commerce Hero',
        'divisi'           => 'outbound'
    ],
    [
        'name'             => 'Oki Subandi',
        'role'             => 'Operator',
        'email'            => 'oki.subandi@nagahytam.co.id',
        'phone'            => '+62 811-0000-0015',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Sortir barang elektronik.',
        'alamat'           => 'Jl. Kenanga No. 25, Bekasi',
        'joined_at'        => '2021-03-03',
        'education'        => 'Teknik Elektro, UI',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Sortir elektronik',
        'skills'           => 'Delicate handling',
        'achievements'     => 'Electronics Ace',
        'divisi'           => 'outbound'
    ],
    [
        'name'             => 'Prio Nugroho',
        'role'             => 'Operator',
        'email'            => 'prio.nugroho@nagahytam.co.id',
        'phone'            => '+62 811-0000-0016',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Koordinasi tim packing shift pagi.',
        'alamat'           => 'Jl. Anggrek No. 26, Jakarta Barat',
        'joined_at'        => '2018-12-12',
        'education'        => 'Manajemen, UI',
        'department'       => 'Gudang',
        'level'            => 'Senior',
        'job_descriptions' => 'Team coordination',
        'skills'           => 'Leadership',
        'achievements'     => 'Morning Lead',
        'divisi'           => 'storage'
    ],
    [
        'name'             => 'Qori Fahmi',
        'role'             => 'Operator',
        'email'            => 'qori.fahmi@nagahytam.co.id',
        'phone'            => '+62 811-0000-0017',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Memeriksa kondisi packing & material.',
        'alamat'           => 'Jl. Bumi No. 27, Semarang',
        'joined_at'        => '2019-07-29',
        'education'        => 'Teknik Material, UGM',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Material inspection',
        'skills'           => 'QC, Material science',
        'achievements'     => 'Material Master',
        'divisi'           => 'storage'
    ],
    [
        'name'             => 'Raden Hadi',
        'role'             => 'Operator',
        'email'            => 'raden.hadi@nagahytam.co.id',
        'phone'            => '+62 811-0000-0018',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Penataan ulang clusters barang.',
        'alamat'           => 'Jl. Sawit No. 28, Surabaya',
        'joined_at'        => '2020-05-20',
        'education'        => 'Manajemen, ITS',
        'department'       => 'Gudang',
        'level'            => 'Intermediate',
        'job_descriptions' => 'Cluster organization',
        'skills'           => 'Organization',
        'achievements'     => 'Cluster Champ',
        'divisi'           => 'storage'
    ],
    [
        'name'             => 'Sandi Permana',
        'role'             => 'Operator',
        'email'            => 'sandi.permana@nagahytam.co.id',
        'phone'            => '+62 811-0000-0019',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Mengelola retur dan recycle packing.',
        'alamat'           => 'Jl. Durian No. 29, Yogyakarta',
        'joined_at'        => '2021-10-10',
        'education'        => 'Administrasi, UNDIP',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Return handling',
        'skills'           => 'Recycling',
        'achievements'     => 'Return Star',
        'divisi'           => 'storage'
    ],
    [
        'name'             => 'Tony Wijaya',
        'role'             => 'Operator',
        'email'            => 'tony.wijaya@nagahytam.co.id',
        'phone'            => '+62 811-0000-0020',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Melakukan pengepakan besar dan berat.',
        'alamat'           => 'Jl. Rambutan No. 30, Medan',
        'joined_at'        => '2018-08-08',
        'education'        => 'Teknik Mesin, USU',
        'department'       => 'Gudang',
        'level'            => 'Intermediate',
        'job_descriptions' => 'Heavy item packing',
        'skills'           => 'Strength, Teamwork',
        'achievements'     => 'Heavy Lifter',
        'divisi'           => 'storage'
    ],
    [
        'name'             => 'Udin Setiawan',
        'role'             => 'Operator',
        'email'            => 'udin.setiawan@nagahytam.co.id',
        'phone'            => '+62 811-0000-0021',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Sorting express shipments.',
        'alamat'           => 'Jl. Melur No. 31, Bandung',
        'joined_at'        => '2019-02-14',
        'education'        => 'Logistik, UNPAD',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Express sorting',
        'skills'           => 'Speed',
        'achievements'     => 'Express Ace',
        'divisi'           => 'storage'
    ],
    [
        'name'             => 'Vito Rinaldi',
        'role'             => 'Operator',
        'email'            => 'vito.rinaldi@nagahytam.co.id',
        'phone'            => '+62 811-0000-0022',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'QC sample batch sebelum packing.',
        'alamat'           => 'Jl. Pinus No. 32, Bekasi',
        'joined_at'        => '2020-09-09',
        'education'        => 'Teknik Kimia, ITB',
        'department'       => 'Gudang',
        'level'            => 'Junior',
        'job_descriptions' => 'Batch QC',
        'skills'           => 'Attention to detail',
        'achievements'     => 'Batch Star',
        'divisi'           => 'storage'
    ],
    [
        'name'             => 'Willy Prakoso',
        'role'             => 'Operator',
        'email'            => 'willy.prakoso@nagahytam.co.id',
        'phone'            => '+62 811-0000-0023',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Menangani logistik internal gudang.',
        'alamat'           => 'Jl. Flamboyan No. 33, Jakarta Timur',
        'joined_at'        => '2021-06-06',
        'education'        => 'Logistik, UI',
        'department'       => 'Gudang',
        'level'            => 'Intermediate',
        'job_descriptions' => 'Internal logistics',
        'skills'           => 'Coordination',
        'achievements'     => 'Logistic Hero',
        'divisi'           => 'storage'
    ],
    [
        'name'             => 'Xavier Paul',
        'role'             => 'Operator',
        'email'            => 'xavier.paul@nagahytam.co.id',
        'phone'            => '+62 811-0000-0024',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Memproses pengiriman ekspor.',
        'alamat'           => 'Jl. Kenanga No. 34, Surabaya',
        'joined_at'        => '2018-04-04',
        'education'        => 'Logistik, ITS',
        'department'       => 'Gudang',
        'level'            => 'Senior',
        'job_descriptions' => 'Export processing',
        'skills'           => 'Export regulations',
        'achievements'     => 'Export Champion',
        'divisi'           => 'storage'
    ],
    [
        'name'             => 'Yusuf Ramadhan',
        'role'             => 'Operator',
        'email'            => 'yusuf.ramadhan@nagahytam.co.id',
        'phone'            => '+62 811-0000-0025',
        'password'         => 'karyawan123',
        'photo_url'        => 'img/profil_operator.jpg',
        'bio'              => 'Koordinasi pengiriman last-mile.',
        'alamat'           => 'Jl. Kemuning No. 35, Medan',
        'joined_at'        => '2019-11-11',
        'education'        => 'Manajemen, USU',
        'department'       => 'Gudang',
        'level'            => 'Intermediate',
        'job_descriptions' => 'Last-mile coordination',
        'skills'           => 'Communication',
        'achievements'     => 'Last Mile Star',
        'divisi'           => 'storage'
    ]
];

        foreach ($userData as $data) {
            // Ambil tahun dari joined_at atau tahun saat ini
            $joined_at = $data['joined_at'] ?? now();
            $year = Carbon::parse($joined_at)->format('Y');
            $prefix = 'NHSA';

            // Hitung jumlah karyawan yang sudah ada untuk tahun ini
            $count = User::where('id_karyawan', 'like', $prefix . $year . '%')->count() + 1;

            // Buat nomor urut dengan format 3 digit (misalnya, 001)
            $nomorUrut = str_pad($count, 3, '0', STR_PAD_LEFT);

            // Gabungkan untuk membentuk id_karyawan
            $data['id_karyawan'] = $prefix . $year . $nomorUrut;

            // Hash password
            $data['password'] = Hash::make($data['password']);

            // Simpan data user
            $user = User::create($data);

            // Buat entri sisa cuti default untuk user baru
            SisaCuti::create([
                'user_id' => $user->id,
                'tahun' => 2025,
                'total_cuti' => 12,
                'cuti_terpakai' => 0,
                'cuti_sisa' => 12
            ]);
        }

        // Data untuk News
      News::create([
    'date' => '2025-06-29',
    'title' => 'Pengumuman Libur Nasional Idul Adha',
    'image_url' => 'img/libur_idul_adha.png',
'description' => '<p>Sehubungan dengan Hari Raya Idul Adha 1446 H, seluruh aktivitas operasional gudang akan diliburkan pada tanggal <strong>8-9 Juli 2025</strong>. Kami mengimbau kepada seluruh operator untuk memastikan bahwa proses sortir, pengepakan, dan pengiriman barang telah diselesaikan sebelum tanggal tersebut. Koordinasikan dengan supervisor masing-masing untuk memastikan tidak ada barang tertunda di area inbound maupun outbound. Pastikan juga seluruh peralatan kerja telah diamankan dan area kerja dalam kondisi rapi sebelum libur dimulai.</p>
<p>Operasional gudang akan kembali berjalan normal pada <strong>10 Juli 2025</strong>. Diharapkan seluruh karyawan dapat hadir tepat waktu sesuai jadwal shift yang berlaku. Jika terdapat kebutuhan mendesak selama masa libur, silakan hubungi tim HR atau supervisor melalui kontak darurat yang telah disediakan. Selamat merayakan Idul Adha bersama keluarga, semoga kita semua diberikan kesehatan dan keselamatan.</p>',
    'link' => 'Null'
]);

News::create([
    'date' => '2025-06-29',
    'title' => 'Pemberitahuan Maintenance Gudang',
    'image_url' => 'img/maintenance_gudang.png',
    'description' => 'Akan dilakukan maintenance sistem rak otomatis dan pengecekan alat berat pada 15 Juli 2025 mulai pukul 08.00 hingga 16.00 WIB. Selama proses maintenance, akses ke area penyimpanan utama dibatasi. Operator diharapkan mengikuti instruksi supervisor dan menjaga keselamatan kerja.',
    'link' => 'Null'
]);

News::create([
    'date' => '2025-06-29',
    'title' => 'Sosialisasi SOP Baru Pengiriman',
    'image_url' => 'img/sop_pengiriman.png',
    'description' => 'Mulai 1 Juli 2025, berlaku SOP baru untuk proses pengiriman barang keluar gudang. Setiap operator wajib melakukan pengecekan barcode dan dokumentasi foto sebelum barang keluar. Pelatihan singkat akan diadakan pada 28 Juni 2025 di ruang meeting lantai 2.',
    'link' => 'Null'
]);


News::create([
    'date' => '2025-06-29',
    'title' => 'Pemberitahuan Pengecekan Alat Pemadam Kebakaran',
    'image_url' => 'img/pengecekan_apar.png',
    'description' => 'Akan dilakukan pengecekan dan pengisian ulang alat pemadam kebakaran (APAR) di seluruh area gudang pada 14 Juli 2025 pukul 09.00-11.00 WIB. Seluruh operator diharapkan tidak memindahkan APAR dari tempat semula dan memberikan akses kepada tim teknisi. Pastikan jalur evakuasi tetap bersih selama proses berlangsung.',
    'link' => 'Null'
]);

News::create([
    'date' => '2025-06-29',
    'title' => 'Pengumuman Update Data Shift Otomatis',
    'image_url' => 'img/update_shift_otomatis.png',
    'description' => 'Mulai 1 Agustus 2025, seluruh data shift operator akan diperbarui secara otomatis melalui sistem. Operator dapat melihat jadwal dan riwayat shift masing-masing di menu Data Shift. Jika ada ketidaksesuaian jadwal, segera laporkan ke supervisor untuk penyesuaian.',
    'link' => 'Null'
]);

News::create([
    'date' => '2025-06-29',
    'title' => 'Pengingat Penggunaan Alat Pelindung Diri (APD)',
    'image_url' => 'img/apd_gudang.png',
    'description' => 'Demi keselamatan kerja, seluruh operator diwajibkan menggunakan APD lengkap (rompi, helm, dan sepatu safety) selama berada di area gudang. Pengawasan akan dilakukan secara berkala oleh tim K3. Pelanggaran akan dikenakan sanksi sesuai aturan perusahaan.',
    'link' => 'Null'
]);

        // Data untuk CutiRequest
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
            'updated_at' => '2025-05-04 22:50:06'
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
            'updated_at' => '2025-05-05 04:22:41'
        ]);

        // Data untuk CutiLogs
        CutiLogs::create([
            'cuti_request_id' => 1,
            'aksi' => 'Dibuat',
            'oleh_user_id' => 7,
            'keterangan' => 'Pengajuan dibuat'
        ]);

        CutiLogs::create([
            'cuti_request_id' => 2,
            'aksi' => 'Disetujui',
            'oleh_user_id' => 9,
            'keterangan' => 'Diterima oleh HR'
        ]);

        // Data untuk LaporanKerja
        LaporanKerja::create([
            'tanggal' => '2025-05-21',
            'nama' => 'Froni',
            'divisi' => 'HR specialist',
            'deskripsi' => 'target sudah tercapai, gudang sudah mengeluarkan barang sebanyak 250 unit'
        ]);

        LaporanKerja::create([
            'tanggal' => '2025-05-05',
            'nama' => 'Froni Wahyudi',
            'divisi' => 'Operator Gudang',
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