<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Article
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'thumbnail' => $this->thumbnail,
            'url' => $this->url,
            'published_at' => $this->published_at,
            'author_id' => $this->author_id,
            'source_id' => $this->source_id,
            'category_id' => $this->category_id,
            'author' => $this->whenLoaded('author', fn () => new AuthorResource($this->author)),
            'category' => $this->whenLoaded('category', fn () => new CategoryResource($this->category)),
            'source' => $this->whenLoaded('source', fn () => new SourceResource($this->source)),
        ];
    }
}
