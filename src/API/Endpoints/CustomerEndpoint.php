<?php

declare(strict_types=1);

namespace Vatly\API\Endpoints;

use Vatly\API\Exceptions\ApiException;
use Vatly\API\Resources\BaseResource;
use Vatly\API\Resources\BaseResourcePage;
use Vatly\API\Resources\Customer;
use Vatly\API\Resources\CustomerCollection;
use Vatly\API\Resources\Links\PaginationLinks;

class CustomerEndpoint extends BaseEndpoint
{
    protected string $resourcePath = "customers";

    const RESOURCE_ID_PREFIX = 'customer_';

    /**
     * @inheritDoc
     */
    protected function getResourceObject(): Customer
    {
        return new Customer($this->client);
    }

    /**
     * @return Customer|BaseResource
     *@throws ApiException
     */
    public function create(array $payload, array $filters = []): BaseResource
    {
        return $this->rest_create($payload, $filters);
    }

    /**
     * @return Customer|BaseResource
     *@throws ApiException
     */
    public function get(string $id, array $parameters = []): BaseResource
    {
        return $this->rest_read($id, $parameters);
    }

    /**
     * @return CustomerCollection|BaseResourcePage
     * @throws ApiException
     */
    public function page(?string $starting_after = null, ?string $ending_before = null, ?int $limit = null, array $parameters = [])
    {
        return $this->rest_list($starting_after, $ending_before, $limit, $parameters);
    }

    protected function getResourcePageObject(int $count, PaginationLinks $links): BaseResourcePage
    {
        return new CustomerCollection($this->client, $count, $links);
    }
}
