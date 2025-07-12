<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Education;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            'High School',
            'Vocational High School',
            'Associate Degree (D3)',
            'Bachelor Degree (S1)',
            'Applied Bachelor Degree (D4)',
            'Master Degree (S2)',
            'Doctorate Degree (S3)',
        ];

        foreach ($levels as $level) {
            Education::create(['name' => $level]);
        }
    }
}
