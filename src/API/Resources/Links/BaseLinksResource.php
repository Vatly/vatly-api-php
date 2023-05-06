<?php

namespace Vatly\API\Resources\Links;

use Vatly\API\Support\Types\Link;

#[\AllowDynamicProperties]
abstract class BaseLinksResource
{
    public Link $self;
}
