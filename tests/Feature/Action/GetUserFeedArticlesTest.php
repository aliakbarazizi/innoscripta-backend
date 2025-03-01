<?php

it('should return empty user feed when no preferred', function () {
    \App\Models\Article::factory(10)->create();

    $user = \App\Models\User::factory()->create();

    $data = app(\App\Actions\Articles\GetUserFeedArticlesPaginate::class)
        ->handle($user);

    expect($data->items())->toHaveCount(0);
});

it('should return user preferred feed', function () {
    $user = \App\Models\User::factory()->create();

    $source = \App\Models\Source::factory()->create();
    $category = \App\Models\Category::factory()->create();

    $user->preferredSources()->attach($source);
    $user->preferredCategories()->attach($category);

    \App\Models\Article::factory(10)->create([
        'source_id' => $source->id,
        'category_id' => $category->id,
    ]);

    $data = app(\App\Actions\Articles\GetUserFeedArticlesPaginate::class)
        ->handle($user);

    expect($data->items())->toHaveCount(10);
});
