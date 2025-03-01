<?php

namespace App\Http\Actions\Authors;

use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetAuthorsPaginate
{
    /**
     * @return LengthAwarePaginator<Author>
     */
    public function handle(?string $query = null): LengthAwarePaginator
    {
        return Author::query()
            ->when($query, function ($query, $q) {
                $query->where('name', 'like', "$q%");
            })
            ->paginate();
    }
}
