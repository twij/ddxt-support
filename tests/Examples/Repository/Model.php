<?php

namespace Ddxt\Support\Tests\Examples\Repository;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use HasFactory;

    protected $table = 'models';

    /**
     * Fillable properties
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'age'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory  Model factory
     */
    protected static function newFactory()
    {
        return ModelFactory::new();
    }
}
