<?php

namespace Ddxt\Support\Repository\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /**
     * Make the model; called by constructor
     *
     * @throws  RepositoryException
     *
     * @return  Model  Model
     */
    public function makeModel(): Model;

    /**
     * Get the model instance
     *
     * @return Model Model
     *
     * @throws BindingResolutionException
     */
    public function getModel(): Model;

    /**
     * Eager load relationships
     *
     * @param  array  $relations  Relationship names to load
     *
     * @return self   Self; chainable
     */
    public function with(array $relations = []): self;

    /**
     * Get first result with criteria/constraints applied
     *
     * @return Model Model
     */
    public function first(): ?Model;

    /**
     * Get all entries with criteria/constraints applied
     *
     * @param  array            $columns  The columns to return
     *
     * @return Collection|null  Collection of entries
     */
    public function all(
        $columns = array('*')
    ): ?Collection;

    /** Get entries; Wrapper for all()
     *
     * @param  array            $columns  The columns to return
     *
     * @return Collection|null  Results
     */
    public function get($columns = array('*')): ?Collection;

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
    ): ?\Illuminate\Pagination\LengthAwarePaginator;

    /**
     * Create an entry
     *
     * @param  array  $data  Model data
     *
     * @return Model  Created model
     */
    public function create(array $data): Model;

    /**
     * Create an entry without saving it
     *
     * @param  array  $data  Model data
     *
     * @return Model  Structured model
     */
    public function make(array $data): Model;

    /**
     * Update an entry
     *
     * @param  array   $data       Data
     * @param  int     $id         Entry id
     * @param  string  $attribute  Attribute that $id refers to
     *
     * @return mixed  Updated model
     */
    public function update(array $data, int $id, string $attribute = 'id'): ?Model;

    /**
     * Delete an entry
     *
     * @param  int   $id  Id to delete
     *
     * @return int   Status
     */
    public function delete(int $id): int;

    /**
     * Find an entry
     *
     * @param  int         $id       ID
     * @param  array       $columns  Column
     *
     * @return null|Model  Result
     */
    public function find(int $id, array $columns = ['*']): ?Model;

    /**
     * Find a model by a field
     *
     * @param  mixed       $attribute  Field to match value
     * @param  mixed       $value      Value to match
     * @param  array       $columns    Columns to select
     *
     * @return null|Model  Result
     */
    public function findBy($attribute, $value, array $columns = ['*']): ?Model;

    /**
     * Sum a field
     *
     * @param  string  $field  Field to sum
     *
     * @return float   Total sum
     */
    public function sum(string $field): float;

    /**
     * Count rows
     *
     * @return int Total rows
     */
    public function count(): int;

    /**
     * Apply scopes to results if required
     *
     * @return self  Self; chainable 
     */
    public function applyScope(): self;

    /**
     * Reset the criteria/constraint scope
     *
     * @param  bool  $reset_model  Reset model instance
     *
     * @return self  Self; chainable
     */
    public function resetScope(bool $reset_model = false): self;

    /**
     * Reset the criteria scope and model
     *
     * @return self  Self; chainable
     */
    public function fresh(): self;

    /**
     * Get SQL query
     *
     * @param   $get_bindings  Get the bindings for the query
     *
     * @return  string         SQL Query
     */
    public function getSQLQuery(bool $get_bindings = true): string;
}
