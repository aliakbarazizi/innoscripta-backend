<?php

it('should return sources', function () {
    \App\Models\Source::factory(10)->create();

    $data = app(\App\Actions\Sources\GetSourcesPaginate::class)
        ->handle();

    expect($data->items())->toHaveCount(10);
});

it('should filter sources by query', function () {
    \App\Models\Source::factory(10)->create();

    \App\Models\Source::factory()->create([
        'name' => 'My Source',
    ]);

    $data = app(\App\Actions\Sources\GetSourcesPaginate::class)
        ->handle(query: 'My');

    expect($data->items())->toHaveCount(1);
});
