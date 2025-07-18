<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\StaffRequest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Andi Nawfal',
            'email' => 'andi@admin.com',
            'group_id' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('andi'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Gerengger Arifal',
            'email' => 'arifal@gmail.com',
            'group_id' => 4,
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'remember_token' => Str::random(10),
        ]);

        StaffRequest::factory(50)->recycle([
            User::factory(10)->create(),
            Position::factory(12)->create()
        ])->create();

        $this->call([
            EducationSeeder::class,
            SallaryTypeSeeder::class,
            SelectionTypeSeeder::class,
        ]);

    }
}
