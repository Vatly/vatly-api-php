<?php

namespace Vatly\API\Endpoints;

use Vatly\API\Exceptions\ApiException;
use Vatly\API\Resources\BaseResource;
use Vatly\API\Resources\BaseResourcePage;
use Vatly\API\Resources\Links\PaginationLinks;
use Vatly\API\Resources\OrderLine;
use Vatly\API\Resources\OrderLineCollection;

class OrderLineEndpoint extends BaseEndpoint
{
    protected string $resourcePath = "orders_lines";

    public ?string $parentId = null;
    protected function getResourceObject(): OrderLine
    {
        return new OrderLine($this->client);
    }

    /**
     * @param string $orderId
     * @param string|null $from
     * @param int|null $limit
     * @param array $parameters
     * @return OrderLineCollection|BaseResourcePage
     * @throws ApiException
     */
    public function page(string $orderId, ?string $from = null, ?int $limit = null, array $parameters = []): BaseResourcePage
    {
        $this->parentId = $orderId;

        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * @return OrderLine|BaseResource|null
     * @throws ApiException
     */
    public function get(string $orderId, string $lineId, array $parameters = [])
    {
        $this->parentId = $orderId;

        return $this->rest_read($lineId, $parameters);
    }


    protected function getResourcePageObject(int $count, PaginationLinks $_links): BaseResourcePage
    {
        return new OrderLineCollection($this->client, $count, $_links);
    }
}
