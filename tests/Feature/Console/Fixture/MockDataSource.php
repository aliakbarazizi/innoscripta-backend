<?php

namespace Tests\Feature\Console\Fixture;

use App\Services\NewsDataSources\DataSource;
use App\Services\NewsDataSources\DataSourceArticle;
use Carbon\Carbon;

class MockDataSource implements DataSource
{
    public function name(): string
    {
        return 'Mock Data Source';
    }

    public function fetch(Carbon $from, callable $callback): void
    {
        for ($i = 0; $i < 10; $i++) {
            $callback(new DataSourceArticle(
                title: fake()->sentence,
                content: fake()->paragraph,
                publishedAt: Carbon::now()->subDays($i),
                category: fake()->word,
                thumbnail: fake()->imageUrl,
                url: fake()->url,
                author: fake()->name,
                source: $this->name(),
            ));
        }
    }
}
