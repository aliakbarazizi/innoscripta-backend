<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->word(),
            'thumbnail' => $this->faker->word(),
            'url' => $this->faker->url(),
            'published_at' => Carbon::now(),
            'provider' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'author_id' => Author::factory(),
            'source_id' => Source::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
