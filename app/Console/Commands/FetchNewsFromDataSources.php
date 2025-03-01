<?php

namespace App\Console\Commands;

use App\Jobs\FetchArticleFromDataSourceJob;
use App\Services\DataSourceManager;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FetchNewsFromDataSources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news-from-data-sources {--date=} {--sync=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news from data sources';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $date = ($this->option('date') ? Carbon::parse($this->option('date')) : now()->subDay())->startOfDay();

        $this->info("Fetching news from data sources for date: {$date}");

        $bar = $this->output->createProgressBar(count(app(DataSourceManager::class)->providers()));

        foreach (app(DataSourceManager::class)->providers() as $provider) {
            $this->info("Fetching news from data source: {$provider}");

            if ($this->option('sync')) {
                dispatch_sync(new FetchArticleFromDataSourceJob($provider, $date));
            } else {
                dispatch(new FetchArticleFromDataSourceJob($provider, $date));
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
