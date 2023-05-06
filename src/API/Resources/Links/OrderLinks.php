<?php

namespace Vatly\API\Resources\Links;

use Vatly\API\Support\Types\Link;

class OrderLinks extends BaseLinksResource
{
    public Link $customer;
    public ?Link $invoice;
}
