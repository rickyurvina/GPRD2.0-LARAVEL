<?php

namespace Database\Factories\Business\Catalogs;

use App\Models\Business\Catalogs\FinancingSource;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinancingSourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FinancingSource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomDigit(),
            'code' => $this->faker->numerify('##'),
            'description' => $this->faker->sentence
        ];
    }
}
