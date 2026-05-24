<?php

namespace Database\Factories;

use App\Models\ResetPassword;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResetPasswordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResetPassword::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->word,
        'email' => $this->faker->word,
        'code' => $this->faker->word,
        'status' => $this->faker->randomDigitNotNull,
        'is_active' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
