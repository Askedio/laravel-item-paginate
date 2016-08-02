<?php

namespace Askedio\ItemPaginator;

trait ItemPaginatorTrait
{
    /**
     * Paginate the given query into a item paginator.
     *
     * @param int      $perPage
     * @param array    $columns
     * @param string   $pageName
     * @param int|null $page
     *
     * @return ItemPaginator
     */
    public function scopeItemPaginate($query, $perPage = null, $columns = ['*'], $pageName = 'from', $from = 0, $field = null, $sort = '>')
    {
        $from = $from ?: ItemPaginator::resolveCurrentPage($pageName, 0);

        $perPage = $perPage ?: $this->getPerPage();

        $defaultField = $field;

        if (!$field) {
            $field = $this->getTable().'.id';
            $defaultField = 'id';
        }

        if ($sort == '<' && $from == 0){
            if ($fromQuery = $this->select($defaultField)->orderBy($field, 'desc')->first()) {
                $from = $fromQuery[$defaultField];
                $sort = '<=';
            }
        }

        $query->where($field, $sort, $from)->take($perPage + 1);

        return new ItemPaginator($query->get($columns), $perPage, $from, [
            'path'     => ItemPaginator::resolveCurrentPath(),
            'pageName' => $pageName,
            'field'    => $field,
        ]);
    }

    public function scopeItemPaginateDesc($query, $perPage = null, $columns = ['*'], $pageName = 'from', $from = 0, $field = null)
    {
        return $query->itemPaginate($perPage, $columns, $pageName, $from, $field, '<');
    }
}
