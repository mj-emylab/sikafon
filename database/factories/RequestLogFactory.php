<?php

namespace Database\Factories;

use App\Models\RequestLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RequestLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
        'app_id' => $this->faker->randomDigitNotNull,
        'uuid' => $this->faker->word,
        'request_status' => $this->faker->word,
        'request_id' => $this->faker->word,
        'payload' => $this->faker->word,
        'response' => $this->faker->word,
        'logable_tpye' => $this->faker->word,
        'logable_id' => $this->faker->randomDigitNotNull,
        'type' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->randomDigitNotNull,
        'is_active' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
