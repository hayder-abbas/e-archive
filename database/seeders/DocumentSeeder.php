<?php

namespace Database\Seeders;

use App\Models\Box;
use App\Models\Document;
use App\Models\Entity;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        Document::factory()
            ->for(Box::factory()->create())
            ->for(Entity::factory()->create())
            ->count(100)
            ->create();
    }
}
