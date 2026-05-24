<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->word,
        'gh_card_id' => $this->faker->word,
        'code' => $this->faker->word,
        'first_name' => $this->faker->word,
        'last_name' => $this->faker->word,
        'middle_name' => $this->faker->word,
        'dob' => $this->faker->word,
        'email' => $this->faker->word,
        'phone_number' => $this->faker->word,
        'address' => $this->faker->word,
        'password' => $this->faker->word,
        'status' => $this->faker->randomDigitNotNull,
        'user_type' => $this->faker->randomDigitNotNull,
        'remember_me' => $this->faker->word,
        'is_active' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
