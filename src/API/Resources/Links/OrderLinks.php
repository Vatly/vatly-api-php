<?php

namespace Vatly\API\Resources\Links;

class OrderLinks extends BaseLinksResource
{
    public Link $customer;
    public ?Link $invoice;
}
