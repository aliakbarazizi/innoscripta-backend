<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Services\NewsDataSources\DataSource;
use App\Services\NewsDataSources\DataSourceArticle;
use Carbon\Carbon;

class DataSourceManager
{
    private ?array $instances = null;

    public function __construct(
        /** @var array<class-string<DataSource>> */
        private array $providers
    ) {}

    public function providers(): array
    {
        return $this->instances ??= array_map(fn (string $provider) => app($provider), $this->providers);
    }

    public function fetchNews(Carbon $date): void
    {
        foreach ($this->providers() as $provider) {
            $provider->fetch($date, fn (DataSourceArticle $article) => $this->saveArticle($article, $provider->name()));
        }
    }

    private function saveArticle(DataSourceArticle $article, string $provider): void
    {
        $category = $article->category ? Category::firstOrCreate(['name' => $article->category]) : null;
        $author = $article->author ? Author::firstOrCreate(['name' => $article->author]) : null;
        $source = Source::firstOrCreate(['name' => $article->source]);

        Article::create([
            'title' => $article->title,
            'content' => $article->content,
            'published_at' => $article->publishedAt,
            'thumbnail' => $article->thumbnail,
            'url' => $article->url,
            'category_id' => $category?->id,
            'author_id' => $author?->id,
            'source_id' => $source->id,
            'provider' => $provider,
        ]);
    }
}
