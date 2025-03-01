<?php

namespace App\Services\NewsDataSources;

use Carbon\Carbon;

interface DataSource
{
    public function name(): string;

    /**
     * @param  callable(DataSourceArticle): void  $callback  callback run on each article
     */
    public function fetch(Carbon $from, callable $callback): void;
}
