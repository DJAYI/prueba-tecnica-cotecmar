<?php

namespace Database\Seeders;

use App\Models\Block;
use App\Models\Piece;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 projects
        Project::factory(10)->create()->each(function ($project) {
            // Each project has 3-5 blocks
            Block::factory(rand(3, 5))->create([
                'project_id' => $project->id
            ])->each(function ($block) {
                // Each block has 5-10 pieces
                // 70% pending, 30% manufactured
                Piece::factory(rand(5, 10))->create([
                    'block_id' => $block->id
                ]);

                Piece::factory(rand(2, 4))->manufactured()->create([
                    'block_id' => $block->id
                ]);
            });
        });
    }
}
