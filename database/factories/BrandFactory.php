<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
     
        $brands = [
            'Louis Vuilton',
            'Gucci',
            'Chanel',
            'Prada',
            'Versace',
            'Armani',
            'Puma',
            'Adidas',
            'Rolex',
            'Nike' ,
            'Apple',
            'Samsung',
            'Us Pole'      
        ];


        return [
           'name' => $this->faker->name,
           'details' => $this->faker->paragraph,
        ];
    }
}
