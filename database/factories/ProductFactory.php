<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);
        return [
            'category_id' => function(){return Category::inRandomOrder()->value('id');},
            'brand_id' => function(){return Brand::inRandomOrder()->value('id');},
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 10000),
            'cover_image' => $this->faker->imageUrl(640, 480),
            'hover_image' => $this->faker->optional()->imageUrl(640, 480),
            'video_url' => $this->faker->optional()->url,
            'short_description' => $this->faker->paragraph,
            'description' => $this->faker->text,
            'detail' => $this->faker->text,
            'specification' => $this->faker->text,
            'sku' => $this->faker->unique()->ean8,
            'bar_code' => $this->faker->unique()->ean13,
            'price' => $this->faker->numberBetween(1000, 50000),
            'discount' => $this->faker->optional()->numberBetween(5, 30),
        ];
    }
}