<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExcelRow>
 */
class ExcelRowFactory extends Factory
{

    protected array $possibleNames = [
        'Fabric',
        'Cotton',
        'Wool',
        'Silk',
        'Linen',
        'Satin',
        'Velvet',
        'Chiffon',
        'Tulle',
        'Lace',
        'Denim',
        'Leather',
        'Polyester',
        'Nylon',
        'Rayon',
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'id'=>$this->faker->numberBetween(),
            'name'=>$this->faker->randomElement($this->possibleNames),
            'date'=>$this->faker->dateTimeBetween(now()->subMonth(), now()->addMonth())->format('Y-m-d')
        ];
    }
}
