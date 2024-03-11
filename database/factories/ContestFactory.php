<?php

namespace Database\Factories;

use App\Models\Contest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContestFactory extends Factory
{
    protected $model = Contest::class;

    public function definition()
    {
        return [
            'winner_prize' => $this->faker->sentence,
            'runner_up_prize' => $this->faker->sentence,
        ];
    }
}