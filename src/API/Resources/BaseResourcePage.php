<?php

declare(strict_types=1);

namespace Vatly\API\Resources;

use ArrayObject;

abstract class BaseResourcePage extends ArrayObject
{
    /**
     * Total number of retrieved objects.
     *
     * @var int
     */
    public int $count;

    /**
     * @var \stdClass|null
     */
    public ?\stdClass $_links;

    /**
     * @param int $count
     * @param \stdClass|null $_links
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
