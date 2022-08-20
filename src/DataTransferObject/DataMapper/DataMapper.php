<?php

namespace Ddxt\Support\DataTransferObject\DataMapper;

use Ddxt\Support\DataTransferObject\Contracts\DataMapperInterface;
use Illuminate\Database\Eloquent\Model;

class DataMapper implements DataMapperInterface
{
    /**
     * Model entry
     *
     * @var Model
     */
    protected Model $entry;

    /**
     * Mappable classes
     *
     * @var array
     */
    protected array $mappable = [];

    /**
     * Map data
     *
     * @param  mixed  $entry  Model entry
     *
     * @return array  Mapped data
     */
    public function __construct(Model $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return json_decode(json_encode($this->entry));
    }

    /**
     * Map data
     *
     * @param  string  $class  Class to map to
     *
     * @return mixed   Mapped output
     */
    public function map(string $class)
    {
        if (isset($this->mappable[$class])) {
            $function = $this->mappable[$class];
            return $this->$function();
        } else {
            throw new \Exception('Class is not mappable');
        }
    }
}
