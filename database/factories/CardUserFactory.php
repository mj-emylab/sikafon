<?php

namespace Database\Factories;

use App\Models\CardUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CardUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
        'card_id' => $this->faker->randomDigitNotNull,
        'uuid' => $this->faker->word,
        'msg' => $this->faker->word,
        'code' => $this->faker->word,
        'issued_at' => $this->faker->word,
        'expired_at' => $this->faker->word,
        'type' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->randomDigitNotNull,
        'right' => $this->faker->randomDigitNotNull,
        'is_active' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
