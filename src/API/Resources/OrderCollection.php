<?php

namespace Vatly\API\Resources;

class OrderCollection extends CursorResourcePage
{
    public function getCollectionResourceName(): ?string
    {
        return 'orders';
    }

    protected function createResourceObject(): Order
    {
        return new Order($this->apiClient);
    }
}
