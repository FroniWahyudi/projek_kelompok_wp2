<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Support\Carbon;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        $shiftTypes = ['Pagi', 'Sore', 'Overtime'];
        $now = Carbon::now();
        $weekYear = $now->year . '-' . $now->isoWeek;

        $users = User::all();

        foreach ($users as $user) {
            // Cek jika user sudah punya shift di minggu ini
            $exists = Shift::where('user_id', $user->id)
                ->where('week_year', $weekYear)
                ->exists();

            if (!$exists) {
                Shift::create([
                    'user_id'   => $user->id,
                    'date'      => $now->toDateString(),
                    'type'      => $shiftTypes[array_rand($shiftTypes)],
                    'week_year' => $weekYear,
                ]);
            }
        }
    }
}
