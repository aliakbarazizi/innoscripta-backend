<?php

return [
    'news' => [
        'providers' => [
            \App\Services\NewsDataSources\Providers\NewYorkTimesProvider::class,
            \App\Services\NewsDataSources\Providers\TheGuardianProvider::class,
            \App\Services\NewsDataSources\Providers\NewsApiOrgProvider::class,
        ],

        'newyorktimes' => [
            'api_key' => env('NYTIMES_API_KEY'),
        ],

        'theguardian' => [
            'api_key' => env('THE_GUARDIAN_API_KEY'),
        ],

        'newsapiorg' => [
            'api_key' => env('NEWSAPI_ORG_API_KEY'),
        ],
    ],
];
