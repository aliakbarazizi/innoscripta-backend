<?php

use App\Actions\Articles\FetchArticlesFromDataSourceProvider;
use Tests\Feature\Console\Fixture\MockDataSource;

it('should fetch articles from datasource', function () {
    /** @var \Tests\TestCase $this */
    app(FetchArticlesFromDataSourceProvider::class)
        ->handle(new MockDataSource, now());

    $this->assertDatabaseCount('articles', 10);
});

it('should dispatch job to fetch articles from datasource', function () {
    Queue::fake();

    $this->artisan('app:fetch-news-from-data-sources');

    Queue::assertPushed(\App\Jobs\FetchArticleFromDataSourceJob::class);
});

it('should create article from fetched data', function () {
    app(\App\Actions\Articles\CreateArticle::class)->handle(
        title: 'Test Article',
        content: 'Test Content',
        publishedAt: now(),
        category: 'Test Category',
        thumbnail: 'Test Thumbnail',
        url: 'Test URL',
        author: 'Test Author',
        source: 'Test Source',
        provider: 'Test Provider',
    );

    $this->assertDatabaseCount('articles', 1);
});
