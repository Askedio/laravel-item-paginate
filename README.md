# Laravel Item Paginator
Paginate based on last item, not page.


[![Build Status](https://travis-ci.org/Askedio/laravel-item-paginate.svg?branch=master)](https://travis-ci.org/Askedio/laravel-item-paginate)
[![StyleCI](https://styleci.io/repos/64736957/shield)](https://styleci.io/repos/64736957)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/7b0e02f728ee495f8328c6603ec24c1b)](https://www.codacy.com/app/gcphost/laravel-item-paginate?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Askedio/laravel-item-paginate&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/7b0e02f728ee495f8328c6603ec24c1b)](https://www.codacy.com/app/gcphost/laravel-item-paginate?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Askedio/laravel-item-paginate&amp;utm_campaign=Badge_Coverage)

# Installation

~~~
composer require askedio/laravel-item-paginate
~~~

Add the following trait to your Models.

```php
use \Askedio\ItemPaginator\ItemPaginatorTrait;
```

If you want the current_page to default to 0 instead of 1 add the following provider to `config/app.php`
```php
\Askedio\ItemPaginator\ItemPaginatorServiceProvider::class,
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
itemPaginate($perPage = null, $columns = ['*'], $pageName = 'from', $from = 0, $field = null)
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

# Disclaimer
I've only tested this with `sqlite` and `mysql` (see tests) so it may not work in every situation. I'll be using it in a "production" API and will try to find possible issues. Please report any you find.
