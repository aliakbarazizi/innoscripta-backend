<?php

namespace App\Services\NewsDataSources\Providers;

use App\Services\NewsDataSources\DataSource;
use App\Services\NewsDataSources\DataSourceArticle;
use App\Services\NewsDataSources\Traits\DataSourceTrait;
use Carbon\Carbon;
use Soundasleep\Html2Text;

class TheGuardianProvider implements DataSource
{
    use DataSourceTrait;

    public string $url = 'https://content.guardianapis.com/';

    public function name(): string
    {
        return 'theguardian';
    }

    public function fetch(Carbon $from, callable $callback): void
    {
        $from = $this->calculateFrom($from);

        $page = 1;

        while (true) {
            $response = \Http::get($this->url.'/search', [
                'api-key' => config('datasource.news.theguardian.api_key'),
                'from-date' => $from->format('Y-m-d'),
                'page' => $page++,
                'page-size' => 100,
                'show-fields' => 'headline,thumbnail,body',
                'show-section' => 'true',
                'show-references' => 'author',
            ])->throw();

            $json = $response->json();

            foreach ($json['response']['results'] ?? [] as $article) {
                $callback(new DataSourceArticle(
                    title: $article['webTitle'],
                    content: Html2Text::convert($article['fields']['body'], ['ignore_errors' => true, 'drop_links' => true]),
                    publishedAt: Carbon::parse($article['webPublicationDate']),
                    category: $article['sectionName'],
                    thumbnail: $article['fields']['thumbnail'] ?? null,
                    url: $article['webUrl'],
                    author: $article['fields']['byline'] ?? 'The Guardian',
                    source: 'The Guardian',
                ));
            }

            if (count($json['response']['results'] ?? []) < 100) {
                break;
            }
        }
    }
}
