<?php

namespace Vatly\API\Endpoints;

use Vatly\API\Exceptions\ApiException;
use Vatly\API\Resources\BaseResourcePage;
use Vatly\API\Resources\Links\PaginationLinks;
use Vatly\API\Resources\Order;
use Vatly\API\Resources\OrderCollection;

class OrderEndpoint extends BaseEndpoint
{
    protected string $resourcePath = "orders";

    const RESOURCE_ID_PREFIX = 'order_';

    protected function getResourceObject(): Order
    {
        return new Order($this->client);
    }


    /**
     * @throws ApiException
     * @return Order
     */
    public function get(string $id, array $parameters = [])
    {
        return $this->rest_read($id, $parameters);
    }

    /**
     * @param $from
     * @param $limit
     * @param array $parameters
     * @return BaseResourcePage
     * @throws ApiException
     */
    public function page($from = null, $limit = null, array $parameters = []): BaseResourcePage
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    protected function getResourcePageObject(int $count, PaginationLinks $_links): BaseResourcePage
    {
        return new OrderCollection($this->client, $count, $_links);
    }
}
