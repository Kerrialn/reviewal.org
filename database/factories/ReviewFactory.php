<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'summary' => $this->faker->text(),
            'user_id' => User::factory(),
            'address_id' => Address::factory()
        ];
    }
}
