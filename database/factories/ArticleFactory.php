<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'summary' => $this->faker->text(50),
            'thumbnail' => $this->faker->imageUrl(250),
            'body' => $this->faker->text(800),
            'user_id' => 1,
            'category_id' => 51,
        ];
    }
}
