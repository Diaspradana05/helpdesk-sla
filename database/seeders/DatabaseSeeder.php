<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            PrioritySeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            TicketSeeder::class,
        ]);
    }
}