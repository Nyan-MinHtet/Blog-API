<?php

namespace Database\Seeders;

use App\Models\Series;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Series::factory()->count(10)->create();
    }
}
