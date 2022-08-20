<?php

namespace Ddxt\Support\DataTransferObject;

class FilterDTO extends DataTransferObject
{
    /**
     * Allowed filter fields
     *
     * @var array
     */
    protected array $filter_allowed = [
        'created_at',
        'created_before',
        'created_after',
        'updated_at',
        'updated_before',
        'updated_after',
        'page',
        'per_page',
        'order_by',
        'order_direction'
    ];

    /**
     * Created at
     *
     * @var string
     */
    public ?string $created_at = null;

    /**
     * Created before
     *
     * @var string
     */
    public ?string $created_before = null;

    /**
     * Created after
     *
     * @var string
     */
    public ?string $created_after = null;
    
    /**
     * Updated at
     *
     * @var string
     */
    public ?string $updated_at = null;

    /**
     * Updated before
     *
     * @var string
     */
    public ?string $updated_before = null;

    /**
     * Updated after
     *
     * @var string
     */
    public ?string $updated_after = null;

    /**
     * Page
     *
     * @var integer
     */
    public ?int $page = 1;

    /**
     * Per page
     *
     * @var integer
     */
    public ?int $per_page = 25;

    /**
     * Order by field
     *
     * @var string
     */
    public ?string $order_by = 'created_at';

    /**
     * Order direction field
     *
     * @var string
     */
    public ?string $order_direction = "DESC";
}
