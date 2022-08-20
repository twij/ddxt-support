<?php

namespace Ddxt\Support\Repository;

use Ddxt\Support\Repository\Contracts\ConstrainableInterface;
use Ddxt\Support\Repository\Contracts\CriteriableInterface;
use Ddxt\Support\Repository\Contracts\RepositoryInterface;
use Ddxt\Support\Repository\Criteria\Constrainable;
use Ddxt\Support\Repository\Criteria\Criteriable;
use Ddxt\Support\Repository\Exceptions\RepositoryException;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class Repository implements RepositoryInterface, CriteriableInterface, ConstrainableInterface
{
    use Criteriable;
    use Constrainable;

    /**
     * Application Container
     */
    private Container $app;

    /**
     * Cache repository
     */
    protected CacheRepository $cache;

    /**
     * Model instance
     */
    protected $model;

    /**
     * Relationships to eager load
     */
    protected array $with = [];

    /**
     * Create repository
     *
     * @param  App                  $app  Application
     *
     * @throws RepositoryException  Exception
     */
    public function __construct(
        Container $app,
        CacheRepository $cache
    ) {
        $this->app = $app;
        $this->cache = $cache;
        $this->criteria = new Collection;
        $this->constraints = new Collection;
        $this->resetScope();
        $this->makeModel();
    }

    /**
     * Specify model qualified class name
     *
     * @return  string  Model qualified class
     */
    abstract public function model(): string;

    /**
     * Get all entries with criteria/constraints applied
     *
     * @param  array            $columns  The columns to return
     *
     * @return Collection|null  Collection of entries
     */
    public function all(
        $columns = array('*')
    ): ?Collection {
        $this->applyCriteria();
        $this->applyConstraints();
        return $this->model->with($this->with)->get($columns);
    }

    /** Get entries; Wrapper for all()
     *
     * @param  array            $columns  The columns to return
     *
     * @return Collection|null  Results
     */
    public function get($columns = array('*')): ?Collection
    {
        return $this->all($columns);
    }

    /**
     * Paginate entries with criteria/constraints applied
     *
     * @param int    $perPage  Amount per page
     * @param array  $columns  Filter columns
     * @param int    $page     Page number
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|null Paginated entries
     */
    public function paginate(
        int $perPage = 1,
        array $columns = ['*'],
        int $page = null
    ): ?\Illuminate\Pagination\LengthAwarePaginator {
        $this->applyCriteria();
        $this->applyConstraints();
        return $this->model
            ->with($this->with)
            ->paginate($perPage, $columns, 'page', $page);
    }

    /**
     * Create an entry
     *
     * @param  array  $data  Model data
     *
     * @return Model  Created model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Get first result with criteria/constraints applied
     *
     * @return Model Model
     */
    public function first(): ?Model
    {
        $this->applyCriteria();
        $this->applyConstraints();
        return $this->model->with($this->with)->first();
    }

    /**
     * Create an entry without saving it
     *
     * @param  array  $data  Model data
     *
     * @return Model  Structured model
     */
    public function make(array $data): Model
    {
        return $this->model->make($data);
    }

    /**
     * Update an entry
     *
     * @param  array   $data       Data
     * @param  int     $id         Entry id
     * @param  string  $attribute  Attribute that $id refers to
     *
     * @return mixed  Updated model
     */
    public function update(array $data, int $id, string $attribute = 'id'): ?Model
    {
        if ($entry = $this->model->where($attribute, '=', $id)->first()) {
            if ($entry->update($data)) {
                return $entry;
            }
        }
        return null;
    }

    /**
     * Delete an entry
     *
     * @param  int   $id  Id to delete
     *
     * @return int   Status
     */
    public function delete(int $id): int
    {
        if ($entry = $this->model->where('id', '=', $id)->first()) {
            return $entry->delete();
        } else {
            return 0;
        }
    }

    /**
     * Find an entry
     *
     * @param  int         $id       ID
     * @param  array       $columns  Column
     *
     * @return null|Model  Result
     */
    public function find(int $id, array $columns = ['*']): ?Model
    {
        $this->applyCriteria();
        $this->applyConstraints();
        return $this->model->with($this->with)->find($id, $columns);
    }

    /**
     * Find a model by a field
     *
     * @param  mixed       $attribute  Field to match value
     * @param  mixed       $value      Value to match
     * @param  array       $columns    Columns to select
     *
     * @return null|Model  Result
     */
    public function findBy($attribute, $value, array $columns = ['*']): ?Model
    {
        $this->applyCriteria();
        $this->applyConstraints();
        return $this->model->with($this->with)->where(
            $attribute,
            '=',
            $value
        )->first($columns);
    }

    /**
     * Eager load relationships
     *
     * @param  array  $relations  Relationship names to load
     *
     * @return self   Self; chainable
     */
    public function with(array $relations = []): self
    {
        $this->with = $relations;
        return $this;
    }

    /**
     * Make the model; called by constructor
     *
     * @throws  RepositoryException
     *
     * @return  Model  Model
     */
    public function makeModel(): Model
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException(
                "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model"
            );
        }

        return $this->model = $model;
    }

    /**
     * Get the model instance
     *
     * @return Model Model
     *
     * @throws BindingResolutionException
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Sum a field
     *
     * @param  string  $field  Field to sum
     *
     * @return float   Total sum
     */
    public function sum(string $field): float
    {
        $this->applyCriteria();
        $this->applyConstraints();
        return $this->model->sum($field);
    }

    /**
     * Count rows
     *
     * @return int Total rows
     */
    public function count(): int
    {
        $this->applyCriteria();
        $this->applyConstraints();
        return $this->model->count();
    }

    /**
     * Reset the criteria/constraint scope
     *
     * @param  bool  $reset_model  Reset model instance
     *
     * @return self  Self; chainable
     */
    public function resetScope(bool $reset_model = false): self
    {
        $this->resetCriteria();
        $this->resetConstraints();

        if ($reset_model) {
            $this->makeModel();
        }

        return $this;
    }

    /**
     * Reset the criteria scope and model
     *
     * @return self  Self; chainable
     */
    public function fresh(): self
    {
        $this->resetScope(true);
        return $this;
    }

    /**
     * Get SQL query
     *
     * @param   $get_bindings  Get the bindings for the query
     *
     * @return  string         SQL Query
     */
    public function getSQLQuery(bool $get_bindings = true): string
    {
        $this->applyCriteria();

        if ($get_bindings) {
            $query = str_replace(
                array('?'),
                array('\'%s\''),
                $this->model->toSql()
            );
            return vsprintf($query, $this->model->getBindings());
        }

        return $this->model->toSql();
    }
}
