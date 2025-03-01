<?php

namespace App\Http\Actions\Articles;

use App\Models\Article;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;

class GetUserFeedArticlesPaginate
{
    /**
     * @return LengthAwarePaginator<Article>
     */
    public function handle(User $user): LengthAwarePaginator
    {
        return Article::query()
            ->whereIn('source_id', function (Builder $query) use ($user) {
                $query->select('source_id')
                    ->from('user_preferred_sources')
                    ->where('user_id', $user->id);
            })
            ->orWhereIn('category_id', function (Builder $query) use ($user) {
                $query->select('category_id')
                    ->from('user_preferred_categories')
                    ->where('user_id', $user->id);
            })
            ->orWhereIn('author_id', function (Builder $query) use ($user) {
                $query->select('author_id')
                    ->from('user_preferred_authors')
                    ->where('user_id', $user->id);
            })
            ->with(['source', 'category', 'author'])
            ->latest('published_at')
            ->paginate();
    }
}
