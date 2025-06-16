<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slip;
use App\Models\User;
use App\Models\SlipEarning;
use App\Models\SlipDeduction;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SlipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users except Manajer and Admin
        $users = User::whereNotIn('role', ['Manajer', 'Admin'])->get();
        
        foreach ($users as $user) {
            // Create 3 months of salary slips for each user
            for ($i = 0; $i < 3; $i++) {
                $period = Carbon::now()->subMonths($i)->startOfMonth();
                $year = $period->format('Y');
                $lastNbr = Slip::whereYear('period', $year)->count() + 1;
                $slipNumber = "SG-{$year}-" . str_pad($lastNbr, 3, '0', STR_PAD_LEFT);
                
                $slip = Slip::create([
                    'slip_number' => $slipNumber,
                    'user_id' => $user->id,
                    'period' => $period,
                    'status' => 'Draft', // Using the correct enum value
                    'net_salary' => 0, // Will be calculated after adding earnings and deductions
                    'is_read' => false,
                    'read_at' => null
                ]);

                // Add Basic Salary
                $basicSalary = rand(4000000, 8000000);
                SlipEarning::create([
                    'slip_id' => $slip->id,
                    'name' => 'Gaji Pokok',
                    'amount' => $basicSalary
                ]);

                // Add Transport Allowance
                SlipEarning::create([
                    'slip_id' => $slip->id,
                    'name' => 'Tunjangan Transport',
                    'amount' => rand(500000, 1000000)
                ]);

                // Add Meal Allowance
                SlipEarning::create([
                    'slip_id' => $slip->id,
                    'name' => 'Tunjangan Makan',
                    'amount' => rand(400000, 800000)
                ]);

                // Add Position Allowance for some employees
                if (rand(0, 1)) {
                    SlipEarning::create([
                        'slip_id' => $slip->id,
                        'name' => 'Tunjangan Jabatan',
                        'amount' => rand(1000000, 2000000)
                    ]);
                }

                // Add standard deductions
                // Tax PPH 21 (5% of basic salary)
                SlipDeduction::create([
                    'slip_id' => $slip->id,
                    'name' => 'PPH 21',
                    'amount' => $basicSalary * 0.05
                ]);

                // BPJS Kesehatan (1% of basic salary)
                SlipDeduction::create([
                    'slip_id' => $slip->id,
                    'name' => 'BPJS Kesehatan',
                    'amount' => $basicSalary * 0.01
                ]);

                // BPJS Ketenagakerjaan (2% of basic salary)
                SlipDeduction::create([
                    'slip_id' => $slip->id,
                    'name' => 'BPJS Ketenagakerjaan',
                    'amount' => $basicSalary * 0.02
                ]);

                // Calculate net salary and update to Terbit status
                $totalEarnings = $slip->earnings()->sum('amount');
                $totalDeductions = $slip->deductions()->sum('amount');
                $slip->update([
                    'net_salary' => $totalEarnings - $totalDeductions,
                    'status' => 'Terbit' // Change status to Terbit after calculations
                ]);
            }
        }
    }
}
