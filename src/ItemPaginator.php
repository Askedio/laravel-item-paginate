<?php

namespace Askedio\ItemPaginator;

use ArrayAccess;
use Countable;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use JsonSerializable;

class ItemPaginator extends \Illuminate\Pagination\Paginator implements Arrayable, ArrayAccess, Countable, IteratorAggregate, JsonSerializable, Jsonable, PaginatorContract
{
    /**
     * Get the URL for the next page.
     *
     * @return string|null
     */
    public function nextPageUrl()
    {
        if ($this->hasMorePages()) {
            return $this->url($this->lastItem());
        }
    }

    /**
     * Get the number of the first item in the slice.
     *
     * @return int
     */
    public function firstItem()
    {
        if (count($this->items) === 0) {
            return;
        }

        return $this->items[0][$this->getField()];
    }

    /**
     * Get the number of the last item in the slice.
     *
     * @return int
     */
    public function lastItem()
    {
        if (count($this->items) === 0) {
            return;
        }

        return $this->items[count($this->items) - 1][$this->getField()];
    }

    protected function getField()
    {
        if (!preg_match('/\.(.*)/', $this->field, $matches)) {
            return $this->field;
        }

        return $matches[1];
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'limit'         => $this->perPage(),
            'current_page'  => $this->currentPage(),
            'next_page_url' => $this->nextPageUrl(),
            'from'          => $this->firstItem(),
            'to'            => $this->lastItem(),
            'data'          => $this->items->toArray(),
        ];
    }
}
