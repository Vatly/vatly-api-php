<?php

declare(strict_types=1);

namespace Vatly\API\Endpoints;

use Vatly\API\Resources\BaseResourcePage;
use Vatly\API\Resources\ResourceFactory;

abstract class BaseCursorPageEndpoint extends BaseEndpoint
{
    /**
     * Get the page object that is used by this API endpoint. Every API endpoint uses one type of page object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return BaseResourcePage
     */
    abstract protected function getResourcePageObject(int $count, \stdClass $_links): BaseResourcePage;

    /**
     * Get a page of objects from the REST API.
     *
     * @param string|null $from The first resource ID you want to include in your list.
     * @param int|null $limit
     * @param array $filters
     *
     * @return BaseResourcePage
     * @throws \Vatly\API\Exceptions\ApiException
     */
    protected function rest_list(string $from = null, int $limit = null, array $filters = []): BaseResourcePage
    {
        $apiPath = $this->getResourcePath() . $this->buildQueryString(
            array_merge(
                [
                    "from" => $from,
                    "limit" => $limit,
                ],
                $filters
            )
        );

        $result = $this->client->performHttpCall(self::REST_LIST, $apiPath);

        $collection = $this->getResourcePageObject($result->count, $result->_links);

        foreach ($result->_embedded->{$collection->getCollectionResourceName()} as $dataResult) {
            $collection[] = ResourceFactory::createResourceFromApiResult(
                $dataResult,
                $this->getResourceObject()
            );
        }

        return $collection;
    }
}
