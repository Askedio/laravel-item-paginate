<?php

namespace Askedio\ItemPaginator;

use ArrayAccess;
use Countable;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use IteratorAggregate;
use JsonSerializable;

class ItemPaginator extends \Illuminate\Pagination\Paginator implements Arrayable, ArrayAccess, Countable, IteratorAggregate, JsonSerializable, Jsonable, PaginatorContract
{
    /**
     * Determine if there are more items in the data source.
     *
     * @return bool
     */
    protected $hasMore;

    /**
     * Create a new paginator instance.
     *
     * @param mixed    $items
     * @param int      $perPage
     * @param int|null $currentPage
     * @param array    $options     (path, query, fragment, pageName)
     *
     * @return void
     */
    public function __construct($items, $perPage, $currentPage = null, array $options = [])
    {
        foreach ($options as $key => $value) {
            $this->{$key} = $value;
        }

        $this->perPage = $perPage;
        $this->currentPage = $this->setCurrentPage($currentPage);
        $this->path = $this->path != '/' ? rtrim($this->path, '/') : $this->path;
        $this->items = $items instanceof Collection ? $items : Collection::make($items);

        $this->checkForMorePages();
    }

    /**
     * Get the current page for the request.
     *
     * @param int $currentPage
     *
     * @return int
     */
    protected function setCurrentPage($currentPage)
    {
        $currentPage = $currentPage ?: static::resolveCurrentPage();

        return $this->isValidPageNumber($currentPage) ? (int) $currentPage : 0;
    }

    /**
     * Check for more pages. The last item will be sliced off.
     *
     * @return void
     */
    protected function checkForMorePages()
    {
        $this->hasMore = count($this->items) > ($this->perPage);

        $this->items = $this->items->slice(0, $this->perPage);
    }

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
     * Get the URL for the previous page.
     *
     * @return string|null
     */
    public function previousPageUrl()
    {
        if ($this->currentPage() > 1) {
            return $this->url($this->firstItem());
        }
    }

    /**
     * Determine if there are more items in the data source.
     *
     * @return bool
     */
    public function hasMorePages()
    {
        return $this->hasMore;
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

        return $this->items[0][$this->field];
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

        return $this->items[count($this->items) - 1][$this->field];
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
            'next_page_url' => $this->nextPageUrl(),
            'prev_page_url' => $this->previousPageUrl(),
            'from'          => $this->firstItem(),
            'to'            => $this->lastItem(),
            'data'          => $this->items->toArray(),
        ];
    }
}
