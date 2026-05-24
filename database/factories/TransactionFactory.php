<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
        'uuid' => $this->faker->word,
        'payment_id' => $this->faker->randomDigitNotNull,
        'amount' => $this->faker->word,
        'code' => $this->faker->word,
        'session_code' => $this->faker->word,
        'transaction_code' => $this->faker->word,
        'type' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->randomDigitNotNull,
        'is_active' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
