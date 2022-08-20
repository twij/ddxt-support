<?php

namespace Ddxt\Support\DataTransferObject\DataFormatter;

use Ddxt\Support\DataTransferObject\Contracts\DataFormatterInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class DataFormatter implements DataFormatterInterface
{
    /**
     * Primary data array
     */
    protected array $data;

    /**
     * Allowed keys
     * Keys not in this array will be stripped
     */
    protected array $allowed = [];

    /**
     * Keys to be reassigned
     * Keys in this array will be reassigned ['from => 'to']
     */
    protected array $reassign = [];

    /**
     * Validation rules
     * Laravel validation rules
     */
    protected array $rules = [];

    /**
     * Default values
     * Values set if matching key null
     */
    protected array $default = [];

    /**
     * Construct data object
     *
     * @param array  $data  Data array
     */
    public function __construct(
        array $data = []
    ) {
        $this->data = $data;
    }

    /**
     * Load array data into dto
     *
     * @param array  $data   Array field => value
     *
     * @return void
     */
    public function loadData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Append additional data to array
     *
     * @param  array  $data  Additional data
     *
     * @return self   Self; chainable
     */
    public function withData(array $data): self
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Append data to the dataset
     *
     * @param  string  $key    Array key
     * @param  mixed   $value  Data to append
     *
     * @return void
     */
    public function append(string $key, $value): void
    {
        if (! isset($this->data[$key])) {
            $this->data[$key] = $value;
        } else {
            throw new \Exception('Key already exists in dataset');
        }
    }

    /**
     * Get the formatted array
     *
     * @return array Formatted array
     */
    public function get(): array
    {
        $this->onGet();
        $this->assignDefaults();
        $this->reassign();
        $this->validate();

        return $this->data;
    }

    /**
     * Return data as json string
     *
     * @return string|null  Json string
     */
    public function toJson(): ?string
    {
        return json_encode($this->data);
    }

    /**
     * Assign default values
     *
     * @return array  Data array
     */
    public function assignDefaults(): array
    {
        foreach ($this->default as $key => $value) {
            if (! isset($this->data[$key])) {
                $this->data[$key] = $value;
            }
        }

        $this->onAssignDefaults();

        return $this->data;
    }

    /**
     * Reassign keys
     *
     * @return array  Data array
     */
    public function reassign(): array
    {
        foreach ($this->reassign as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $_key => $_value) {
                    if (isset($this->data[$_key], $this->data) && isset($this->data[$_key])) {
                        $this->data[$key][$_value] = $this->data[$_key];
                        unset($this->data[$_key]);
                    }
                }
            } else {
                if (isset($this->data[$key], $this->data) && $this->data[$key]) {
                    $this->data[$value] = $this->data[$key];
                    unset($this->data[$key]);
                }
            }
        }

        $this->data = Arr::only(
            $this->data,
            array_unique(
                array_merge(
                    Arr::flatten($this->reassign),
                    $this->allowed
                )
            )
        );

        $this->onReassigned();

        return $this->data;
    }

    /**
     * Validate data
     *
     * @return array  Data array
     */
    public function validate(): array
    {
        $validator = Validator::make($this->data, $this->rules);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $this->data = $validator->validated();

        $this->onValidated();

        return $this->data;
    }

    /**
     * Filter array
     * Strips null/blank entries
     *
     * @return array  Filtered data array
     */
    public function filter(): array
    {
        $this->data = array_filter($this->data);

        $this->onFiltered();

        return $this->data;
    }

    /**
     * Called at beginning of get method
     * Before defaults are assigned
     *
     * @return mixed
     */
    public function onGet()
    {
        return;
    }

    /**
     * Called after default values set
     * Before fields are reassigned
     *
     * @return mixed
     */
    public function onAssignDefaults()
    {
        return;
    }

    /**
     * Called after reassignment
     * Before validation
     *
     * @return mixed
     */
    public function onReassigned()
    {
        return;
    }

    /**
     * Called after validation
     *
     * @return mixed
     */
    public function onValidated()
    {
        return;
    }

    /**
     * Called after filter
     *
     * @return mixed
     */
    public function onFiltered()
    {
        return;
    }
}
