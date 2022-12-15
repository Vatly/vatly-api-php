<?php

declare(strict_types=1);

namespace Vatly\API\Endpoints;

use Vatly\API\Resources\BaseResource;
use Vatly\API\Resources\Checkout;

class CheckoutEndpoint extends BaseEndpoint
{
    /**
     * @inheritDoc
     */
    protected function getResourceObject(): Checkout
    {
        return new Checkout($this->client);
    }

    /**
     * @throws \Vatly\API\Exceptions\ApiException
     * @return Checkout|BaseResource
     */
    public function create(array $payload, array $filters = []): BaseResource
    {
        return $this->rest_create($payload, $filters);
    }

    /**
     * @throws \Vatly\API\Exceptions\ApiException
     * @return Checkout|BaseResource
     */
    public function get(string $id, array $parameters = []): BaseResource
    {
        return $this->rest_read($id, $parameters);
    }
}
