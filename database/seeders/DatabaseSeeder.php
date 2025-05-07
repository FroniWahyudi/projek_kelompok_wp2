<?php
namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
    }
}
