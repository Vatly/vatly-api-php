<?php

namespace Vatly\API\Resources\Links;

use Vatly\API\Support\Types\Link;

class PaginationLinks extends BaseLinksResource
{
    public ?Link $previous;
    public ?Link $next;
}
