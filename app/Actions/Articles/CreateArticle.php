<?php

namespace App\Actions\Articles;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;

class CreateArticle
{
    public function handle(
        string $title,
        string $content,
        \DateTime $publishedAt,
        ?string $category,
        ?string $thumbnail,
        ?string $url,
        ?string $author,
        ?string $source,
        string $provider,
    ): void {
        $category = $category ? Category::firstOrCreate(['name' => $category]) : null;
        $author = $author ? Author::firstOrCreate(['name' => $author]) : null;
        $source = Source::firstOrCreate(['name' => $source]);

        Article::create([
            'title' => $title,
            'content' => $content,
            'published_at' => $publishedAt,
            'thumbnail' => $thumbnail,
            'url' => $url,
            'category_id' => $category?->id,
            'author_id' => $author?->id,
            'source_id' => $source->id,
            'provider' => $provider,
        ]);
    }
}
