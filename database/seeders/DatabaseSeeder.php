<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

       

        \App\Models\User::create([
           'username' => 'administrator',
           'password' => bcrypt('admin123')
        ]);

        \App\Models\Customer::factory(10)->create();
        \App\Models\Suplier::factory(20)->create();
        \App\Models\Barang::factory(100)->create();
    }
}
