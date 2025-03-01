<?php

namespace App\Services\NewsDataSources\Providers;

use App\Services\NewsDataSources\DataSource;
use App\Services\NewsDataSources\DataSourceArticle;
use App\Services\NewsDataSources\Traits\DataSourceTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class NewsApiOrgProvider implements DataSource
{
    use DataSourceTrait;

    public const MAX_PAGES = 1; // Developer token is limited to 100 latest articles

    public string $url = 'https://newsapi.org/v2/';

    public function name(): string
    {
        return 'newsapi.org';
    }

    public function fetch(Carbon $from, callable $callback): void
    {
        $from = $this->calculateFrom($from);

        $this
            ->sources()
            ->chunk(20) // NewsApi allows 20 sources per request
            ->each(function (Collection $sources) use ($from, $callback) {
                $page = 1;

                while (true) {
                    $response = \Http::get($this->url.'/everything', [
                        'apiKey' => config('datasource.news.newsapiorg.api_key'),
                        'from' => $from->toISOString(),
                        'sources' => $sources->implode(','),
                        'page' => $page++,
                        'pageSize' => 100,
                    ])->throw();

                    $json = $response->json();

                    foreach ($json['articles'] ?? [] as $article) {
                        $authorText = explode(',', $article['author'] ?? '');

                        $callback(new DataSourceArticle(
                            title: $article['title'],
                            content: $article['description'] ?? '',
                            publishedAt: Carbon::parse($article['publishedAt']),
                            category: null, // NewsApi doesn't provide category :(
                            thumbnail: $article['urlToImage'],
                            url: $article['url'],
                            author: ! empty($authorText[0]) ? trim($authorText[0]) : ($article['source']['name'] ?? 'NewsApi.org'),
                            source: $article['source']['name'] ?? null,
                        ));
                    }

                    if (count($json['articles'] ?? []) < 100) {
                        break;
                    }

                    // @phpstan-ignore-next-line
                    if ($page > self::MAX_PAGES) {
                        break;
                    }
                }
            });
    }

    /**
     * @return Collection<number>
     */
    protected function sources(): Collection
    {
        return \Cache::remember('newsapiorg_sources', now()->addMonth(), function () {
            $response = \Http::get($this->url.'/sources', [
                'apiKey' => config('datasource.news.newsapiorg.api_key'),
            ])->throw();

            /** @var array{sources: array<array{id: string}> | null} $json */
            $json = $response->json();

            return collect($json['sources'] ?? [])->map(function ($source) {
                return $source['id'];
            });
        });
    }
}
