<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title  =   $this->faker->sentence();
        return [
            'title'         =>  $title,
            'slug'          =>  Str::slug($title),
            'summary'       =>  $this->faker->text(200),
            'content'       =>  $this->faker->paragraph(10, true),
            'image_url'     =>  $this->faker->imageUrl(640, 480),
            'user_id'       =>  $this->faker->numberBetween(1,4)
        ];
    }
}
