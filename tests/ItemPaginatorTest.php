<?php

namespace Askedio\ItemPaginator\Tests;

use Askedio\ItemPaginator\Tests\App\User;

class ItemPaginatorTest extends BaseTestCase
{
    public function testPaginator()
    {
        $limit = 2;

        // Yes, factories are better.
        $user = new User();

        $user->create([
          'id'       => 100,
          'name'     => 'test',
          'email'    => 'test@test.com',
          'password' => 'test',
        ]);

        $user->create([
          'id'       => 190,
          'name'     => 't0est',
          'email'    => 't0est@test.com',
          'password' => 'te0st',
        ]);

        $user->create([
          'id'       => 210,
          'name'     => 't90est',
          'email'    => 't09est@test.com',
          'password' => 'te90st',
        ]);

        $user->create([
          'name'     => 't0uest',
          'email'    => 't0eust@test.com',
          'password' => 'te0st',
        ]);

        $user->create([
          'name'     => 'trader_rocr100uest',
          'email'    => 't00eust@test.com',
          'password' => 't0e0st',
        ]);


        $paginated = $user->orderBy('id', 'desc')->itemPaginateDesc($limit);

        $results = $paginated->toArray();

        $this->assertInstanceOf('Askedio\ItemPaginator\ItemPaginator', $paginated);
        $this->assertEquals(212, $results['from']);
        $this->assertEquals(211, $results['to']);
        $this->assertEquals('http://localhost?from=211', $results['next_page_url']);


        $paginated = $user->itemPaginate($limit, ['*'], 'from', 0, 'id');

        $results = $paginated->toArray();

        $this->assertEquals(100, $results['from']);
        $this->assertEquals(190, $results['to']);
        $this->assertEquals('http://localhost?from=190', $results['next_page_url']);


        $paginated = $user->itemPaginate($limit, ['*'], 'from', 190, 'id');

        $results = $paginated->toArray();

        $this->assertEquals(210, $results['from']);
        $this->assertEquals(211, $results['to']);
        $this->assertEquals('http://localhost?from=211', $results['next_page_url']);


        request()->merge(['from' => 1000]);

        $paginated = $user->itemPaginate($limit);

        $results = $paginated->toArray();
        $this->assertEquals(null, $results['from']);
        $this->assertEquals(null, $results['to']);
    }
}
