<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Block>
 */
class BlockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => strtoupper($this->faker->bothify('????????')),
            'name' => strtoupper($this->faker->bothify('????')),
            'project_id' => Project::inRandomOrder()->first()?->id ?? Project::factory(),
        ];
    }
}
