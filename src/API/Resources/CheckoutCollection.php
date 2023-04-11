<?php

namespace Vatly\API\Resources;

class CheckoutCollection extends CursorResourcePage
{
    public function getCollectionResourceName(): ?string
    {
        return 'checkouts';
    }

    protected function createResourceObject(): Checkout
    {
        return new Checkout($this->apiClient);
    }
}
