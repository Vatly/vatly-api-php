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
     * @return Checkout|BaseResource
     *@throws ApiException
     */
    public function create(array $payload, array $filters = []): BaseResource
    {
        return $this->rest_create($payload, $filters);
    }

    /**
     * @return Checkout|BaseResource
     *@throws ApiException
     */
    public function get(string $id, array $parameters = []): BaseResource
    {
        return $this->rest_read($id, $parameters);
    }

    /**
     * @return CheckoutCollection|BaseResourcePage
     * @throws ApiException
     */
    public function page(
        ?string $starting_after = null,
        ?string $ending_before = null,
        ?int $limit = null,
        array $parameters = []
    ) {
        return $this->rest_list($starting_after, $ending_before, $limit, $parameters);
    }

    protected function getResourcePageObject(int $count, PaginationLinks $links): BaseResourcePage
    {
        return new CheckoutCollection($this->client, $count, $links);
    }
}
