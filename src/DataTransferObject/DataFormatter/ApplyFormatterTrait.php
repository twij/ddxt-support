<?php

namespace Ddxt\Support\DataTransferObject\DataFormatter;

use Ddxt\Support\DataTransferObject\Contracts\DataFormatterInterface;

trait ApplyFormatterTrait
{
    /**
     * Apply a data formatter to a dataset
     *
     * @param  DataFormatterInterface $formatter Formatter interface
     *
     * @return array                  Formatted data
     */
    public function applyFormatter(DataFormatterInterface $formatter): array
    {
        $formatter->loadData($this->toArray());
        return $formatter->get();
    }

    /**
     * Strip null values and apply a formatter to a dataset
     *
     * @param DataFormatterInterface $formatter Formatter interface
     *
     * @return array                 Formatted data
     */
    public function applyFormatterFiltered(DataFormatterInterface $formatter): array
    {
        $formatter->loadData($this->toArray());
        $formatter->filter();
        return $formatter->get();
    }
}
