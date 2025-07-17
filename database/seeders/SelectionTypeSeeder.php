<?php

namespace Database\Seeders;

use App\Models\SelectionType;
use Illuminate\Database\Seeder;

class SelectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            'Document Check',
            'Written Test',
            'Initial Interview',
            'Technical Interview',
            'Psychological Test',
            'Final Interview',
            'Medical Checkup',
        ];

        foreach ($levels as $level) {
            SelectionType::create(['name' => $level]);
        }
    }
}
