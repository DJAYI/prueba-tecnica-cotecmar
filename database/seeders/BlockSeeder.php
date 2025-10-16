<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Luego crea bloques (se asociarán automáticamente a los proyectos)
        Block::factory()->count(20)->create();
    }
}
