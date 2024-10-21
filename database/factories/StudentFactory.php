<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_name' => $this->faker->name(),
            'class_teacher_id' => Teacher::inRandomOrder()->first()->id,
            'class' => $this->faker->unique()->word(),
            'admission_date' => $this->faker->date(),
            'yearly_fees' => $this->faker->randomFloat(2, 1000, 10000),
        ];
    }
}
