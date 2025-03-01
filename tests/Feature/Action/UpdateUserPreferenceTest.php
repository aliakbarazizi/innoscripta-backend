<?php

it('should update user preference', function () {
    $user = \App\Models\User::factory()->create();

    $source = \App\Models\Source::factory()->create();
    $category = \App\Models\Category::factory()->create();
    $author = \App\Models\Author::factory()->create();

    app(\App\Actions\Users\UpdateUserPreference::class)
        ->handle(
            $user,
            categories: [$category->id],
            sources: [$source->id],
            authors: [$author->id]
        );

    expect($user->preferredSources->first()->id)->toBe($source->id);
    expect($user->preferredCategories->first()->id)->toBe($category->id);
    expect($user->preferredAuthors->first()->id)->toBe($author->id);
});

it('should clear user preference', function () {
    $user = \App\Models\User::factory()->create();

    $source = \App\Models\Source::factory()->create();
    $category = \App\Models\Category::factory()->create();
    $author = \App\Models\Author::factory()->create();

    $user->preferredSources()->attach($source);
    $user->preferredCategories()->attach($category);
    $user->preferredAuthors()->attach($author);

    app(\App\Actions\Users\UpdateUserPreference::class)
        ->handle($user);

    expect($user->preferredSources)->toHaveCount(0);
    expect($user->preferredCategories)->toHaveCount(0);
    expect($user->preferredAuthors)->toHaveCount(0);
});
