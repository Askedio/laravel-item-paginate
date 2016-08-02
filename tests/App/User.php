<?php

namespace Askedio\ItemPaginator\Tests\App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use \Askedio\ItemPaginator\ItemPaginatorTrait;

    protected $table = 'users';

    protected $fillable = ['id', 'name', 'email', 'password'];
}
