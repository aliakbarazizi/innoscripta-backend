<?php

namespace App\Actions\Articles;

use App\Services\NewsDataSources\DataSource;
use App\Services\NewsDataSources\DataSourceArticle;
use Carbon\Carbon;

class FetchArticlesFromDataSourceProvider
{
    public function __construct(
        private CreateArticle $createArticle,
    ) {}

    public function handle(DataSource $provider, Carbon $date): void
    {
        $provider->fetch(
            $date,
            fn (DataSourceArticle $article) => $this->createArticle->handle(
                title: $article->title,
                content: $article->content,
                publishedAt: $article->publishedAt,
                category: $article->category,
                thumbnail: $article->thumbnail,
                url: $article->url,
                author: $article->author,
                source: $article->source,
                provider: $provider->name(),
            )
        );
    }
}
