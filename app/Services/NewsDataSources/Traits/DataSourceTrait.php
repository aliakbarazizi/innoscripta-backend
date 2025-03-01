<?php

namespace App\Services\NewsDataSources\Traits;

use App\Models\Article;
use Carbon\Carbon;

trait DataSourceTrait
{
    public function getLastArticle(): ?Article
    {
        return Article::latest('published_at')->where('provider', $this->name())->first();
    }

    protected function calculateFrom(Carbon $from): Carbon
    {
        if ($lastArticle = $this->getLastArticle()) {
            return $from->isBefore($lastArticle->published_at) ? $lastArticle->published_at : $from;
        }

        return $from;
    }
}
