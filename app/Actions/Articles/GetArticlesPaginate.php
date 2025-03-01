<?php

namespace App\Actions\Articles;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class GetArticlesPaginate
{
    /**
     * @return LengthAwarePaginator<Article>
     */
    public function handle(
        ?string $query = null,
        ?array $sources = null,
        ?array $categories = null,
        ?array $authors = null
    ): LengthAwarePaginator {
        return Article::query()
            ->when($query, function (Builder $query, $q) {
                $query->whereFullText(['title', 'content'], $q);
            })
            ->when($sources, function (Builder $query, $sources) {
                $query->whereIn('source_id', $sources);
            })
            ->when($categories, function (Builder $query, $categories) {
                $query->whereIn('category_id', $categories);
            })
            ->when($authors, function (Builder $query, $authors) {
                $query->whereIn('author_id', $authors);
            })
            ->with(['source', 'category', 'author'])
            ->latest('published_at')
            ->paginate();
    }
}
