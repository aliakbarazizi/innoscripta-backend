<?php

namespace App\Actions\Sources;

use App\Models\Source;
use Illuminate\Pagination\LengthAwarePaginator;

class GetSourcesPaginate
{
    /**
     * @return LengthAwarePaginator<Source>
     */
    public function handle(?string $query = null): LengthAwarePaginator
    {
        return Source::query()
            ->when($query, function ($query, $q) {
                $query->where('name', 'like', "$q%");
            })
            ->paginate();
    }
}
