<?php

namespace Vatly\API\Endpoints;

use Vatly\API\Exceptions\ApiException;
use Vatly\API\Resources\BaseResource;
use Vatly\API\Resources\BaseResourcePage;
use Vatly\API\Resources\Links\PaginationLinks;
use Vatly\API\Resources\OneOffProduct;
use Vatly\API\Resources\OneOffProductCollection;

class OneOffProductEndpoint extends BaseEndpoint
{
    protected string $resourcePath = "one-off-products";

    const RESOURCE_ID_PREFIX = 'one_off_product_';

    protected function getResourceObject(): OneOffProduct
    {
        return new OneOffProduct($this->client);
    }


    /**
     * @throws ApiException
     * @return OneOffProduct
     */
    public function get(string $id, array $parameters = [])
    {
        return $this->rest_read($id, $parameters);
    }

    public function create(array $payload, array $filters = []): BaseResource
    {
        return $this->rest_create($payload, $filters);
    }

    /**
     * @return OneOffProductCollection|BaseResourcePage
     * @throws ApiException
     */
    public function page(?string $from = null, ?int $limit = null, array $parameters = []): BaseResourcePage
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    protected function getResourcePageObject(int $count, PaginationLinks $_links): BaseResourcePage
    {
        return new OneOffProductCollection($this->client, $count, $_links);
    }
}
