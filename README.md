# Laravel Item Paginator
Paginate based on last item, not page.

# Installation

~~~
composer install..
~~~

Add the following trait to your base Model or Models you want to use this feature on.

```php
use \Askedio\ItemPaginator\ItemPaginatorTrait;
```


# Usage
This package is based off simplePaginate and will take the same parameters.
```php
$users = new User();

$paginated = $users->itemPaginate();

dd($paginated);
```

The past parameter is the field that will be used to paginate by, defaults to `id`.

```php
itemPaginate($perPage = null, $columns = ['*'], $pageName = 'from', $from = 0, $field = 'id')
```