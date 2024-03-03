<?php

namespace App\Model\Tag;

class TagListResponse
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
