<?php

namespace Vatly\API\Resources\Links;

class Link
{
    public string $href;
    public string $type;


    public function __construct(string $href, string $type)
    {
        $this->href = $href;
        $this->type = $type;
    }
}
