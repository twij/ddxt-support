<?php

namespace Ddxt\Support\DataTransferObject\Contracts;

interface DataMapperInterface
{
    /**
     * Map to array
     *
     * @return array  Array data
     */
    public function toArray(): array;

    /**
     * Map data
     *
     * @param  string $class  Class to map to
     *
     * @return mixed  Mapped output
     */
    public function map(string $class);
}
