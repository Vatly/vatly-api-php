<?php

declare(strict_types=1);

namespace Vatly\API\Resources;

use ArrayObject;
use Vatly\API\Exceptions\ApiException;
use Vatly\API\Resources\Links\PaginationLinks;
use Vatly\API\VatlyApiClient;

abstract class BaseResourcePage extends ArrayObject
{
    /**
     * Total number of retrieved objects.
     *
     * @var int
     */
    public int $count;

    /**
     * @var PaginationLinks|null
     */
    public $_links;

    /**
     * @var BaseResource[]
     */
    public array $_embedded;

    protected VatlyApiClient $apiClient;

    /**
     * @param VatlyApiClient $apiClient
     * @param int $count
     * @param PaginationLinks|null $_links
     */
    public function __construct(VatlyApiClient $apiClient, $count, $_links)
    {
        $this->apiClient = $apiClient;
        $this->count = $count;
        $this->_links = $_links;
        parent::__construct();
    }


    /**
     * @return string|null
     */
    abstract public function getCollectionResourceName(): ?string;



    abstract protected function createResourceObject();

    /**
     * Return the next set of resources when available
     *
     * @return BaseResourcePage|null
     * @throws ApiException
     */
    final public function next(): ?BaseResourcePage
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
     * @return BaseResourcePage|null
     * @throws ApiException
     */
    final public function previous(): ?BaseResourcePage
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

    /**
     * Determine whether the collection has a next page available.
     *
     * @return bool
     */
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
