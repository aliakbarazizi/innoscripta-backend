<?php

it('should return categories', function () {
    \App\Models\Category::factory(10)->create();

    $data = app(\App\Actions\Categories\GetCategoriesPaginate::class)
        ->handle();

    expect($data->items())->toHaveCount(10);
});

it('should filter categories by query', function () {
    \App\Models\Category::factory(10)->create();

    \App\Models\Category::factory()->create([
        'name' => 'My Category',
    ]);

    $data = app(\App\Actions\Categories\GetCategoriesPaginate::class)
        ->handle(query: 'My');

    expect($data->items())->toHaveCount(1);
});
