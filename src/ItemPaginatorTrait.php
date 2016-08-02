<?php

namespace Askedio\ItemPaginator;


trait ItemPaginatorTrait
{
    /**
     * Paginate the given query into a item paginator.
     *
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return ItemPaginator
     */
    public function scopeItemPaginate($query, $perPage = null, $columns = ['*'], $pageName = 'from', $from = 0, $field = 'id')
    {
        $from = $from ?: ItemPaginator::resolveCurrentPage($pageName, 0);

        $perPage = $perPage ?: $this->getPerPage();

        $query->where($field, '>', $from)->take($perPage + 1);

        return new ItemPaginator($query->get($columns), $perPage, $from, [
            'path' => ItemPaginator::resolveCurrentPath(),
            'pageName' => $pageName,
            'field' => $field,
        ]);
    }
}
