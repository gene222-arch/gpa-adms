<?php

namespace Database\Factories;

use App\Models\ReliefGood;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReliefGoodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReliefGood::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category' => $this->faker->name,
            'name' => $this->faker->name,
            'quantity' => rand(1, 20),
            'to' => $this->faker->name
        ];
    }

    public function funcName()
    {
        return $this->state([
            'category' => 'new Value',
            'name' => 'new Name'
        ]);
    }

}
