<?php

namespace Vatly\API\Resources;

use Vatly\API\Exceptions\ApiException;
use Vatly\API\Resources\Links\PaginationLinks;
use Vatly\API\VatlyApiClient;

abstract class CursorResourcePage extends BaseResourcePage
{
    protected VatlyApiClient $apiClient;

    /**
     * @param VatlyApiClient $apiClient
     * @param int $count
     * @param \stdClass|PaginationLinks|null $_links
     */
    public function __construct(VatlyApiClient $apiClient, $count, $_links)
    {
        $this->apiClient = $apiClient;
        parent::__construct($count, $_links);
    }

    abstract protected function createResourceObject();

    /**
     * Return the next set of resources when available
     *
     * @return CursorResourcePage|null
     * @throws ApiException
     */
    final public function next(): ?CursorResourcePage
    {
        if (! $this->hasNext()) {
            return null;
        }

        $result = $this->apiClient->performHttpCallToFullUrl(VatlyApiClient::HTTP_GET, $this->_links->next->href);

        $collection = new static($this->apiClient, $result->count, $result->_links);

        foreach ($result->_embedded->{$collection->getCollectionResourceName()} as $dataResult) {
            $collection[] = ResourceFactory::createResourceFromApiResult($dataResult, $this->createResourceObject());
        }

        return $collection;
    }

    /**
     * Return the previous set of resources when available
     *
     * @return CursorResourcePage|null
     * @throws ApiException
     */
    final public function previous(): ?CursorResourcePage
    {
        if (! $this->hasPrevious()) {
            return null;
        }

        $result = $this->apiClient->performHttpCallToFullUrl(VatlyApiClient::HTTP_GET, $this->_links->previous->href);

        $collection = new static($this->client, $result->count, $result->_links);

        foreach ($result->_embedded->{$collection->getCollectionResourceName()} as $dataResult) {
            $collection[] = ResourceFactory::createResourceFromApiResult($dataResult, $this->createResourceObject());
        }

        return $collection;
    }

    public function hasNext(): bool
    {
        return isset($this->_links->next, $this->_links->next->href);
    }

    /**
     * Determine whether the collection has a previous page available.
     *
     * @return bool
     */
    public function hasPrevious(): bool
    {
        return isset($this->_links->previous, $this->_links->previous->href);
    }
}
