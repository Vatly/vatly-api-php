<?php

namespace Vatly\API\Endpoints;

use Vatly\API\Exceptions\ApiException;
use Vatly\API\Resources\BaseResource;
use Vatly\API\Resources\BaseResourcePage;
use Vatly\API\Resources\Chargeback;
use Vatly\API\Resources\ChargebackCollection;
use Vatly\API\Resources\Links\PaginationLinks;

class ChargebackEndpoint extends BaseEndpoint
{
    protected string $resourcePath = "chargebacks";

    const RESOURCE_ID_PREFIX = 'chargeback_';

    protected function getResourceObject(): Chargeback
    {
        return new Chargeback($this->client);
    }


    /**
     * @throws ApiException
     * @return Chargeback|BaseResource
     */
    public function get(string $id, array $parameters = [])
    {
        return $this->rest_read($id, $parameters);
    }

    /**
     * @return ChargebackCollection|BaseResourcePage
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
        return new ChargebackCollection($this->client, $count, $links);
    }
}
