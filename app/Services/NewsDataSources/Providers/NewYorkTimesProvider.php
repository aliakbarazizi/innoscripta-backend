<?php

namespace App\Services\NewsDataSources\Providers;

use App\Services\NewsDataSources\DataSource;
use App\Services\NewsDataSources\DataSourceArticle;
use App\Services\NewsDataSources\Traits\DataSourceTrait;
use Carbon\Carbon;

class NewYorkTimesProvider implements DataSource
{
    use DataSourceTrait;

    public const MAX_PAGES = 10; // Developer token is limited to 10 pages

    public string $url = 'https://api.nytimes.com/';

    public function name(): string
    {
        return 'newyorktimes';
    }

    public function fetch(Carbon $from, callable $callback): void
    {
        $from = $this->calculateFrom($from);

        $page = 1;

        while (true) {

            $response = \Http::get($this->url.'/svc/search/v2/articlesearch.json', [
                'api-key' => config('datasource.news.newyorktimes.api_key'),
                'sort' => 'newest',
                'page' => $page++,
                'begin_date' => $from->format('Ymd'),
            ])->throw();

            $json = $response->json();

            foreach ($json['response']['docs'] ?? [] as $article) {
                $authorText = str_replace('By ', '', $article['byline']['original'] ?? '');
                $authorText = explode(' and ', $authorText);
                $authorText = explode(', ', $authorText[0]);

                $callback(new DataSourceArticle(
                    title: $article['headline']['main'],
                    content: $article['lead_paragraph'], // nytimes doesn't provide content
                    publishedAt: Carbon::parse($article['pub_date']),
                    category: $article['section_name'] ?? 'General',
                    thumbnail: isset($article['multimedia'][0]['url']) ? 'https://www.nytimes.com/'.$article['multimedia'][0]['url'] : null,
                    url: $article['web_url'],
                    author: $authorText[0] ?: 'The New York Times',
                    source: $article['source'] ?? 'The New York Times',
                ));
            }

            if (count($json['response']['docs'] ?? []) < 10) {
                break;
            }

            if ($page > self::MAX_PAGES) {
                break;
            }

            sleep(12);
        }
    }
}
