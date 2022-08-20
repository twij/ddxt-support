<?php

namespace Ddxt\Support\DataTransferObject;

use Ddxt\Support\DataTransferObject\DataFormatter\ApplyFormatterTrait;

class DataTransferObject
{
    use ApplyFormatterTrait;

    /**
     * Required fields
     * Use data formatter for validation
     */
    protected array $required = [];

    /**
     * Allowed fields
     * Fields not present in this array will be stripped
     */
    protected array $allowed = [];

    /**
     * Reassigned fields
     * Fields present in this array will be renamed
     */
    protected array $reassign = [];

    /**
     * Data transfer object base class
     *
     * @param array $array Construct data
     */
    public function __construct(array $array = [])
    {
        foreach ($array as $key => $value) {
            if (in_array($key, $this->allowed) || count($this->allowed) === 0) {
                if (isset($this->reassign[$key])) {
                    $_key = $this->reassign[$key];
                    $this->$_key = $value;
                } else {
                    $this->$key = $value;
                }
            }
        }

        $this->onDataAdded();
    }

    /**
     * Get property
     *
     * @param  mixed  $name  Property name
     * 
     * @return mixed  Property value 
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Set property
     *
     * @param  mixed  $name   Property name
     * @param  mixed  $value  Property value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * Append a key/value pair to data set
     *
     * @param string $key   Key name
     * @param mixed  $value Data
     *
     * @return bool Status
     */
    public function append(string $key, $value): bool
    {
        $this->$key = $value;

        $this->onDataAdded();

        return $this->verify();
    }

    /**
     * Append fields from an array
     *
     * @param array $data New data
     *
     * @return bool Status
     */
    public function appendArray(array $data): bool
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->allowed) || count($this->allowed) === 0) {
                if (isset($this->reassign[$key])) {
                    $_key = $this->reassign[$key];
                    $this->$_key = $value;
                } else {
                    $this->$key = $value;
                }
            }
        }

        $this->onDataAdded();

        return $this->verify();
    }

    /**
     * Called when data is added to the dataset
     *
     * @return void
     */
    public function onDataAdded()
    {
        return;
    }

    /**
     * Verify required data exists
     *
     * @return bool Status
     */
    public function verify(): bool
    {
        foreach ($this->required as $key) {
            if (!isset($this->$key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Verify the data and throw exception on failure
     *
     * @return boolean
     */
    public function verifyStrict(): bool
    {
        foreach ($this->required as $key) {
            if (!isset($this->$key)) {
                throw new \Exception('Required field ' . $key . ' is not set');
            }
        }

        return true;
    }

    /**
     * Convert to array
     *
     * @return array Structured array
     */
    public function toArray(): array
    {
        return json_decode(json_encode($this), true);
    }
}
