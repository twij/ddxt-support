<?php

namespace Ddxt\Support\Tests\Examples\Repository;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;

class ModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    public function __construct(
        $count = null,
        ?Collection $states = null,
        ?Collection $has = null,
        ?Collection $for = null,
        ?Collection $afterMaking = null,
        ?Collection $afterCreating = null,
        $connection = null
    ) {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);
        $this->makeTable();
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'age' => fake()->numberBetween(10, 100)
        ];
    }

    /**
     * Make table because we don't use migrations
     *
     * @return void
     *
     * @throws BindingResolutionException 
     */
    public function makeTable(): void
    {
        $schema = app()->make('Illuminate\Database\Schema\Builder');

        if (! $schema->hasTable('models')) {
            $schema->create('models', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('age');
                $table->timestamps();
            });
        }
    }
}
