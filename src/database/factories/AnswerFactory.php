<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Answer::class; // 対象のモデルを指定

    public function definition(): array
    {

        $gender = $this->faker->boolean ? 1 : 2;

        $lastName = $this->faker->lastName;
        $firstName = $gender === 1 ? $this->faker->firstNameMale : $this->faker->firstNameFemale;

        return [
            'fullname' => $lastName . ' ' . $firstName,
            'gender' => $gender,
            'age_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6]),
            'email' => $this->faker->unique()->safeEmail(),
            'is_send_email' => $this->faker->boolean(),
            'feedback' => $this->faker->realText(50),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
            'deleted_at' => $this->faker->optional(0.2)->dateTime(),
        ];
    }
}
