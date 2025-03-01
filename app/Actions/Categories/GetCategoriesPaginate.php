<?php

namespace App\Actions\Categories;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class GetCategoriesPaginate
{
    /**
     * @return LengthAwarePaginator<Category>
     */
    public function handle(?string $query = null): LengthAwarePaginator
    {
        return Category::query()
            ->when($query, function ($query, $q) {
                $query->where('name', 'like', "$q%");
            })
            ->paginate();
    }
}
