<?php

namespace Vatly\API\Endpoints;

use Vatly\API\Exceptions\ApiException;
use Vatly\API\Resources\BaseResource;
use Vatly\API\Resources\BaseResourcePage;
use Vatly\API\Resources\Chargeback;
use Vatly\API\Resources\ChargebackCollection;
use Vatly\API\Resources\Links\PaginationLinks;

class OrderChargebackEndpoint extends BaseEndpoint
{
    protected string $resourcePath = "orders_chargebacks";

    protected function getResourceObject(): Chargeback
    {
        return new Chargeback($this->client);
    }

    protected function getResourcePageObject(int $count, PaginationLinks $links): ChargebackCollection
    {
        return new ChargebackCollection($this->client, $count, $links);
    }

    /**
     * @return BaseResource|Chargeback
     * @throws ApiException
     */
    public function getForOrderId(string $orderId, string $chargebackId, array $parameters = [])
    {
        $this->parentId = $orderId;

        return parent::rest_read($chargebackId, $parameters);
    }

    /**
     * @return BaseResourcePage|ChargebackCollection
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
