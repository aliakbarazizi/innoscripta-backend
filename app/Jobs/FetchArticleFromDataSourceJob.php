<?php

namespace App\Jobs;

use App\Actions\Articles\FetchArticlesFromDataSourceProvider;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchArticleFromDataSourceJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private string $provider,
        private Carbon $date,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(FetchArticlesFromDataSourceProvider $fetchArticlesFromDataSourceProvider): void
    {
        $fetchArticlesFromDataSourceProvider->handle(app($this->provider), $this->date);
    }
}
