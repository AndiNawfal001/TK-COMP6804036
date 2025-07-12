<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SallaryType;

class SallaryTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Monthly',
            'Weekly',
            'Daily',
            'Hourly',
            'Per Project',
        ];

        foreach ($types as $type) {
            SallaryType::create(['name' => $type]);
        }
    }
}
