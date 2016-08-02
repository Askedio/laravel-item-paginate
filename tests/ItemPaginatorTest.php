<?php

namespace Askedio\ItemPaginator\Tests;

use Faker\Factory;
use Askedio\ItemPaginator\Tests\App\User;

class ItemPaginatorTest extends BaseTestCase
{
    public function testThatFilterCanUseNl2Br()
    {

        $limit = 2;

        (new User())->create([
          'id' => 100,
          'name' => 'test',
          'email' => 'test@test.com',
          'password' => 'test'
        ]);


        (new User())->create([
          'id' => 190,
          'name' => 't0est',
          'email' => 't0est@test.com',
          'password' => 'te0st'
        ]);

        (new User())->create([
          'id' => 210,
          'name' => 't90est',
          'email' => 't09est@test.com',
          'password' => 'te90st'
        ]);

        (new User())->create([
          'name' => 't0uest',
          'email' => 't0eust@test.com',
          'password' => 'te0st'
        ]);

        (new User())->create([
          'name' => 'trader_rocr100uest',
          'email' => 't00eust@test.com',
          'password' => 't0e0st'
        ]);

        $users = new User();

        $paginated = $users->itemPaginate($limit);

        $results = $paginated->toArray();

        $this->assertInstanceOf('Askedio\ItemPaginator\ItemPaginator', $paginated);
        $this->assertEquals($results['from'], 100);
        $this->assertEquals($results['to'], 190);
        $this->assertEquals($results['next_page_url'], 'http://localhost?from=190');
        $this->assertEquals($results['prev_page_url'], null);


        $paginated = $users->itemPaginate($limit, ['*'], 'from', 100);

        $results = $paginated->toArray();


        $this->assertEquals($results['from'], 190);
        $this->assertEquals($results['to'], 210);
        $this->assertEquals($results['next_page_url'], 'http://localhost?from=210');
        $this->assertEquals($results['prev_page_url'], 'http://localhost?from=190');


        $paginated = $users->itemPaginate($limit, ['*'], 'from', 10000);

        $results = $paginated->toArray();
        $this->assertEquals($results['from'], null);
        $this->assertEquals($results['to'], null);


    }
}
