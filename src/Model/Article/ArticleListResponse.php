<?php

namespace App\Model\Article;

use App\Model\Tag\TagItem;

class ArticleListResponse
{
    /**
     * @param TagItem[] $items
     */
    private array $items;

    /**
     * @param TagItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return TagItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
