<?php

it('should return authors', function () {
    \App\Models\Author::factory(10)->create();

    $data = app(\App\Actions\Authors\GetAuthorsPaginate::class)
        ->handle();

    expect($data->items())->toHaveCount(10);
});

it('should filter authors by name', function () {
    \App\Models\Author::factory(10)->create();

    $author = \App\Models\Author::factory()->create([
        'name' => 'John Doe',
    ]);

    $data = app(\App\Actions\Authors\GetAuthorsPaginate::class)
        ->handle(query: 'John');

    expect($data->items())->toHaveCount(1);
});
