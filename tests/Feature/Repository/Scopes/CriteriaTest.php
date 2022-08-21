<?php

namespace Ddxt\Support\Tests\Feature;

use Ddxt\Support\Tests\Examples\Repository\Criteria\IdMoreThanCriteria;
use Ddxt\Support\Tests\Examples\Repository\Model;
use Ddxt\Support\Tests\TestCase;

class CriteriaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_criteria()
    {
        $model = Model::factory()->count(100)->create();
        $this->assertDatabaseCount('models', 100);
        $this->assertTrue(true);

        $repo = app()->make('Ddxt\Support\Tests\Examples\Repository\Contracts\ModelCriteriableRepositoryInterface');

        $repo->pushCriteria(new IdMoreThanCriteria(50));

        $this->assertEquals($repo->count(), 50);
    }
}
