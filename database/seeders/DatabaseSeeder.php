<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Conductor;
use App\Models\Owner;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        Owner::factory()->has(Vehicle::factory()->count(2))->count(5)->create();
        $conductors = Conductor::factory(5)->create();
        $vehicles = Vehicle::all();

        foreach ($conductors as $conductor) {
            foreach ($vehicles as $vehicle) {
                $vehicle->conductors()->attach($conductor->id);
            }
        }

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
