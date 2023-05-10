<?php

declare(strict_types=1);

namespace Vatly\API\Endpoints;

use Vatly\API\Exceptions\ApiException;
use Vatly\API\Resources\BaseResource;
use Vatly\API\Resources\BaseResourcePage;
use Vatly\API\Resources\Checkout;
use Vatly\API\Resources\CheckoutCollection;
use Vatly\API\Resources\Links\PaginationLinks;

class CheckoutEndpoint extends BaseEndpoint
{
    protected string $resourcePath = "checkouts";

    const RESOURCE_ID_PREFIX = 'checkout_';

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

    /**
     * @return CheckoutCollection|BaseResourcePage
     * @throws ApiException
     */
    public function page(?string $from = null, ?int $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    protected function getResourcePageObject(int $count, PaginationLinks $_links): BaseResourcePage
    {
        return new CheckoutCollection($this->client, $count, $_links);
    }
}
