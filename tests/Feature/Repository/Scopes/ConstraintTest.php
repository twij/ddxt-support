<?php

namespace Ddxt\Support\Tests\Feature;

use Ddxt\Support\Tests\Examples\Repository\Model;
use Ddxt\Support\Tests\TestCase;

class ConstraintTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_constraint()
    {
        $model = Model::factory()->count(100)->create();
        $this->assertDatabaseCount('models', 100);
        $this->assertTrue(true);

        $repo = app()->make('Ddxt\Support\Tests\Examples\Repository\Contracts\ModelConstrainableRepositoryInterface');

        $repo->pushConstraint(function ($model) {
            return $model->where('id', '>', 50);
        });

        $this->assertEquals($repo->count(), 50);
    }
}
