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



The last parameter is the field that will be used to paginate by, defaults to `id`.

```php
itemPaginate($perPage = null, $columns = ['*'], $pageName = 'from', $from = 0, $field = 'id')
```

# Example Output
```php
array:6 [
  "limit" => 2
  "next_page_url" => "http://localhost?from=190"
  "prev_page_url" => null
  "from" => 100
  "to" => 190
  "data" => array:2 [
    0 => array:8 [
      "id" => 100
      "name" => "test"
      "email" => "test@test.com"
      "password" => "test"
      "remember_token" => null
      "created_at" => "2016-08-02 18:13:19"
      "updated_at" => "2016-08-02 18:13:19"
      "deleted_at" => null
    ]
    1 => array:8 [
      "id" => 190
      "name" => "test2"
      "email" => "test2@test.com"
      "password" => "test"
      "remember_token" => null
      "created_at" => "2016-08-02 18:13:19"
      "updated_at" => "2016-08-02 18:13:19"
      "deleted_at" => null
    ]
  ]
]
```