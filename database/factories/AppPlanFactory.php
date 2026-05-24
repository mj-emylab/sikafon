<?php

namespace Database\Factories;

use App\Models\AppPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AppPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
        'code_id' => $this->faker->randomDigitNotNull,
        'qrcode_id' => $this->faker->randomDigitNotNull,
        'uuid' => $this->faker->word,
        'amount' => $this->faker->word,
        'about' => $this->faker->word,
        'type' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->randomDigitNotNull,
        'is_active' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
