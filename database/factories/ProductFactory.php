<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Company;
use App\Models\Sale;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'product_name' => $this->faker->word, 
            'company_id' => Company::factory(),
            'price' => $this->faker->numberBetween(100, 300),  
            'stock' => $this->faker->randomDigit, 
            'comment' => $this->faker->sentence,  
            'img_path' => 'https://picsum.photos/200/300', 
        ];
    }
}
