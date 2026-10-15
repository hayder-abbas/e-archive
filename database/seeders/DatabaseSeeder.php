<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->hasAuditLogs(50)->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'role' => 'admin'
        ]);

        $this->call([
            BoxSeeder::class,
            EntitySeeder::class,
            DocumentSeeder::class,
            BorrowSeeder::class,
            AuditLogSeeder::class,
        ]);
    }
}
