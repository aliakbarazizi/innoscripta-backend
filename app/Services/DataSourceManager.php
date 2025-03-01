<?php

namespace App\Services;

use App\Services\NewsDataSources\DataSource;

class DataSourceManager
{
    public function __construct(
        /** @var array<class-string<DataSource>> */
        private array $providers
    ) {}

    public function providers(): array
    {
        return $this->providers;
    }
}
