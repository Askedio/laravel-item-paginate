<?php

namespace Askedio\ItemPaginator;

use Illuminate\Support\ServiceProvider;

class ItemPaginatorServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        ItemPaginator::currentPathResolver(function () {
            return $this->app['request']->url();
        });

        ItemPaginator::currentPageResolver(function ($pageName = 'from') {
            $page = $this->app['request']->input($pageName);

            if (filter_var($page, FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
                return $page;
            }

            return 0;
        });
    }
}
