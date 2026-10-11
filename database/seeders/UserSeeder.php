<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@demo.test'],
            ['name' => 'Admin Demo', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $admin->syncRoles('admin');

        foreach (range(1, 3) as $i) {
            $agent = User::updateOrCreate(
                ['email' => "agent{$i}@demo.test"],
                ['name' => "Agent {$i}", 'password' => Hash::make('password'), 'email_verified_at' => now()]
            );
            $agent->syncRoles('agent');
        }

        $customer = User::updateOrCreate(
            ['email' => 'customer@demo.test'],
            ['name' => 'Customer Demo', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $customer->syncRoles('customer');

        User::factory(10)->create()->each(fn (User $u) => $u->assignRole('customer'));
    }
}