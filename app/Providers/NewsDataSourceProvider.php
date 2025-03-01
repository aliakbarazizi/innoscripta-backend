<?php

namespace App\Providers;

use App\Services\DataSourceManager;
use App\Services\NewsDataSources\DataSource;
use Carbon\Laravel\ServiceProvider;

class NewsDataSourceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(DataSourceManager::class, function () {
            return new DataSourceManager(config('datasource.news.providers'));
        });

        $this->app->beforeResolving(DataSource::class, function ($class) {
            $this->app->singletonIf($class);
        });
    }
}
