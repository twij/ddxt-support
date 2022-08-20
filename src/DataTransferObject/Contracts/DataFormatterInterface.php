<?php

namespace Ddxt\Support\DataTransferObject\Contracts;

interface DataFormatterInterface
{
    /**
     * Load array data into dto
     *
     * @param array  $data   Array field => value
     *
     * @return void
     */
    public function loadData(array $data): void;

    /**
     * Append additional data to array
     *
     * @param  array  $data  Additional data
     *
     * @return self   Self; chainable
     */
    public function withData(array $data): self;

    /**
     * Append data to the dataset
     *
     * @param  string  $key    Array key
     * @param  mixed   $value  Data to append
     *
     * @return void
     */
    public function append(string $key, $value): void;

    /**
     * Get the formatted array
     *
     * @return array Formatted array
     */
    public function get(): array;

    /**
     * Return data as json string
     *
     * @return string|null  Json string
     */
    public function toJson(): ?string;

    /**
     * Assign default values
     *
     * @return array  Data array
     */
    public function assignDefaults(): array;

    /**
     * Reassign keys
     *
     * @return array  Data array
     */
    public function reassign(): array;

    /**
     * Validate data
     *
     * @return array  Data array
     */
    public function validate(): array;

    /**
     * Filter array
     * Strips null/blank entries
     *
     * @return array  Filtered data array
     */
    public function filter(): array;

    /**
     * Called at beginning of get method
     * Before defaults are assigned
     *
     * @return mixed
     */
    public function onGet();

    /**
     * Called after default values set
     * Before fields are reassigned
     *
     * @return mixed
     */
    public function onAssignDefaults();

    /**
     * Called after reassignment
     * Before validation
     *
     * @return mixed
     */
    public function onReassigned();

    /**
     * Called after validation
     *
     * @return mixed
     */
    public function onValidated();

    /**
     * Called after filter
     *
     * @return mixed
     */
    public function onFiltered();
}
