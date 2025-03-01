<?php

it('should return articles', function () {
    \App\Models\Article::factory(10)->create();

    $data = app(\App\Actions\Articles\GetArticlesPaginate::class)
        ->handle();

    expect($data->items())->toHaveCount(10);
});

it('should filter articles by query', function () {
    /** @var \Tests\TestCase $this */
    \App\Models\Article::factory(10)->create();

    \App\Models\Article::factory()->create([
        'title' => 'My Article',
        'content' => 'Article content',
    ]);

    // Full text search is not supported in pending transactions
    \DB::commit();

    $data = app(\App\Actions\Articles\GetArticlesPaginate::class)
        ->handle(query: 'article');

    \App\Models\Article::query()->delete();

    expect($data->items())->toHaveCount(1);
});

it('should filter articles by sources', function () {
    \App\Models\Article::factory(10)->create();

    $source = \App\Models\Source::factory()->create();

    \App\Models\Article::factory(5)->create([
        'source_id' => $source->id,
    ]);

    $data = app(\App\Actions\Articles\GetArticlesPaginate::class)
        ->handle(sources: [$source->id]);

    expect($data->items())->toHaveCount(5);
});

it('should filter articles by categories', function () {
    \App\Models\Article::factory(10)->create();

    $category = \App\Models\Category::factory()->create();

    \App\Models\Article::factory(5)->create([
        'category_id' => $category->id,
    ]);

    $data = app(\App\Actions\Articles\GetArticlesPaginate::class)
        ->handle(categories: [$category->id]);

    expect($data->items())->toHaveCount(5);
});

it('should filter articles by authors', function () {
    \App\Models\Article::factory(10)->create();

    $author = \App\Models\Author::factory()->create();

    \App\Models\Article::factory(5)->create([
        'author_id' => $author->id,
    ]);

    $data = app(\App\Actions\Articles\GetArticlesPaginate::class)
        ->handle(authors: [$author->id]);

    expect($data->items())->toHaveCount(5);
});
