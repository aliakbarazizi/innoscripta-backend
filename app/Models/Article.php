<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $thumbnail
 * @property string $url
 * @property Carbon $published_at
 * @property int|null $author_id
 * @property int $source_id
 * @property int|null $category_id
 * @property string $provider
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Author|null $author
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\Source $source
 *
 * @method static \Database\Factories\ArticleFactory factory($count = null, $state = [])
 * @method static Builder<static>|Article newModelQuery()
 * @method static Builder<static>|Article newQuery()
 * @method static Builder<static>|Article query()
 * @method static Builder<static>|Article whereAuthorId($value)
 * @method static Builder<static>|Article whereCategoryId($value)
 * @method static Builder<static>|Article whereContent($value)
 * @method static Builder<static>|Article whereCreatedAt($value)
 * @method static Builder<static>|Article whereId($value)
 * @method static Builder<static>|Article whereProvider($value)
 * @method static Builder<static>|Article wherePublishedAt($value)
 * @method static Builder<static>|Article whereSourceId($value)
 * @method static Builder<static>|Article whereThumbnail($value)
 * @method static Builder<static>|Article whereTitle($value)
 * @method static Builder<static>|Article whereUpdatedAt($value)
 * @method static Builder<static>|Article whereUrl($value)
 *
 * @mixin Eloquent
 */
class Article extends Model
{
    use HasFactory;

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<Author, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo<Source, $this>
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
}
