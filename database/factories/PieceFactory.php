<?php

namespace Database\Factories;

use App\Enums\PieceStatusEnum;
use App\Models\Block;
use App\Models\Piece;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Piece>
 */
class PieceFactory extends Factory
{
    protected $model = Piece::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $theoricalWeight = $this->faker->numberBetween(100, 5000);

        return [
            'id' => null,
            'name' => strtoupper($this->faker->bothify('???')), // 3 characters
            'theorical_weight' => $theoricalWeight,
            'real_weight' => null,
            'status' => PieceStatusEnum::PENDING,
            'block_id' => Block::inRandomOrder()->first()?->id ?? Block::factory(),
            'user_id' => null,
            'manufactured_at' => null,
        ];
    }

    /**
     * Indicate that the piece is manufactured.
     */
    public function manufactured(): static
    {
        return $this->state(function (array $attributes) {
            $theoricalWeight = $attributes['theorical_weight'];
            $realWeight = $theoricalWeight + $this->faker->numberBetween(-50, 50);

            return [
                'status' => PieceStatusEnum::MANUFACTURED,
                'real_weight' => max(0, $realWeight), // Ensure non-negative
                'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
                'manufactured_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            ];
        });
    }
}
