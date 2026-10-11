<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Low', 'slug' => 'low', 'level' => 1, 'first_response_minutes' => 1440, 'resolution_minutes' => 7200, 'color' => 'gray'],
            ['name' => 'Medium', 'slug' => 'medium', 'level' => 2, 'first_response_minutes' => 480, 'resolution_minutes' => 4320, 'color' => 'blue'],
            ['name' => 'High', 'slug' => 'high', 'level' => 3, 'first_response_minutes' => 120, 'resolution_minutes' => 1440, 'color' => 'orange'],
            ['name' => 'Critical', 'slug' => 'critical', 'level' => 4, 'first_response_minutes' => 30, 'resolution_minutes' => 240, 'color' => 'red'],
        ];

        foreach ($data as $item) {
            Priority::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}