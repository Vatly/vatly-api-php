<?php

namespace Vatly\API\Resources\Links;

class PaginationLinks extends BaseLinksResource
{
    public ?Link $previous;
    public ?Link $next;
}
