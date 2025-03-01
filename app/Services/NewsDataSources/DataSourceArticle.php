<?php

namespace App\Services\NewsDataSources;

class DataSourceArticle
{
    public function __construct(
        public string $title,
        public string $content,
        public \DateTime $publishedAt,
        public ?string $category,
        public ?string $thumbnail,
        public ?string $url,
        public ?string $author,
        public ?string $source,
    ) {}
}
