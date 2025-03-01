<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
 * @property-read int|null $articles_count
 *
 * @method static \Database\Factories\AuthorFactory factory($count = null, $state = [])
 * @method static Builder<static>|Author newModelQuery()
 * @method static Builder<static>|Author newQuery()
 * @method static Builder<static>|Author query()
 * @method static Builder<static>|Author whereCreatedAt($value)
 * @method static Builder<static>|Author whereId($value)
 * @method static Builder<static>|Author whereName($value)
 * @method static Builder<static>|Author whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Author extends Model
{
    use HasFactory;

    /**
     * @return HasMany<Article, $this>
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
