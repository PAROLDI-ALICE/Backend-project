<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $professional = [
            'lastname' => 'lagaffe',
            'firstname'=> 'michel',
            'phoneNumber' => '1122334455',
            'profession' => 'auxiliaire de vie',
            'city' => 'nice',
            'experienceYears' => '7',
            'experienceDetails' => 'blablabla',
            'skills' => 'mobility',
            'price' => '28',
            'diplomas' => 'oui',
            'languages' => 'francais et anglais',
            'email' => 'michellagaffe@gmail.com',
            'password' => Hash::make('Edouard&03'),
        ];

        DB::table('professionals')->insert($professional);
    }
}
