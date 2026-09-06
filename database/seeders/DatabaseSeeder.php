<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Demo data (accounts + sample school data) is only created when DEMO_MODE=true.
        if (config('demo.enabled')) {
            $this->call(DemoSeeder::class);
        }
    }
}
