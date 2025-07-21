<?php

namespace Database\Seeders;

use App\Models\Religions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            'Islam',
            'Other',
            'Confucianism',
            'Buddhism',
            'Hinduism',
            'Catholicism',
            'Protestant Christianity',
        ];

        foreach ($levels as $level) {
            Religions::create(['name' => $level]);
        }
    }
}
