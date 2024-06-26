<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Election>
 */
class ElectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $startDate = $this->faker->dateTimeBetween('1 day', '+1 year');
        // $endDate = Carbon::parse($startDate)->addWeek();

        return [
            'election_name' => $this->faker->word(),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_date' => $this->faker->dateTimeBetween('+2 week', '+1 months'),
            'status' => $this->faker->randomElement(['Building', 'Scheduling', 'Running', 'Closed']),
            'admin_id' => '',
            'description' => $this->faker->sentence(40),
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
