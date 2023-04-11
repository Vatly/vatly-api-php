<?php

declare(strict_types=1);

namespace Vatly\API\Resources;

use ArrayObject;
use Vatly\API\Resources\Links\BaseLinksResource;
use Vatly\API\Resources\Links\PaginationLinks;

abstract class BaseResourcePage extends ArrayObject
{
    /**
     * Total number of retrieved objects.
     *
     * @var int
     */
    public int $count;

    /**
     * @var \stdClass|BaseLinksResource|null
     */
    public $_links;

    public array $_embedded;

    /**
     * @param int $count
     * @param \stdClass|BaseLinksResource|PaginationLinks|null $_links
     */
    public function __construct($count, $_links)
    {
        $this->count = $count;
        $this->_links = $_links;
        parent::__construct();
    }

    /**
     * @return string|null
     */
    abstract public function getCollectionResourceName(): ?string;
}
