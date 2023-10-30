<?php

namespace Vatly\API\Endpoints;

use Vatly\API\Exceptions\ApiException;
use Vatly\API\Resources\BaseResource;
use Vatly\API\Resources\BaseResourcePage;
use Vatly\API\Resources\Links\PaginationLinks;
use Vatly\API\Resources\Refund;
use Vatly\API\Resources\RefundCollection;

class OrderRefundEndpoint extends BaseEndpoint
{
    protected string $resourcePath = "orders_refunds";

    protected function getResourceObject(): Refund
    {
        return new Refund($this->client);
    }

    protected function getResourcePageObject(int $count, PaginationLinks $links): RefundCollection
    {
        return new RefundCollection($this->client, $count, $links);
    }

    /**
     * @return BaseResource|Refund
     * @throws ApiException
     */
    public function getForOrderId(string $orderId, string $refundId, array $parameters = [])
    {
        $this->parentId = $orderId;

        return parent::rest_read($refundId, $parameters);
    }

    /**
     * @return BaseResourcePage|RefundCollection
     * @throws ApiException
     */
    public function pageForOrderId(
        string $orderId,
        ?string $starting_after = null,
        ?string $ending_before = null,
        ?int $limit = null,
        array $parameters = []
    ) {
        $this->parentId = $orderId;

        return parent::rest_list($starting_after, $ending_before, $limit, $parameters);
    }
}
