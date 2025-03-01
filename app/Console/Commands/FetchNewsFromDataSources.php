<?php

namespace App\Console\Commands;

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
    protected $signature = 'app:fetch-news-from-data-sources {--date=}';

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

        app(DataSourceManager::class)->fetchNews($date);
    }
}
