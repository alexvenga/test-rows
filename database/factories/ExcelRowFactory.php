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


    public function definition(): array
    {
        return [
            'id' => $this->faker->unique(maxRetries: 100000)->numberBetween(100),
            'name' => $this->faker->randomElement($this->possibleNames),
            'date' => $this->faker->dateTimeBetween(now()->subMonth(), now()->addMonth())->format('Y-m-d')
        ];
    }
}
