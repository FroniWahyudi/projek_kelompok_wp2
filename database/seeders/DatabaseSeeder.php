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
    }
}
