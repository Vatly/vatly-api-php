<?php

declare(strict_types=1);

namespace Vatly\API\Resources;

use Vatly\API\VatlyApiClient;

#[\AllowDynamicProperties]
class ResourceFactory
{
    /**
     * Create resource object from Api result
     *
     * @param object $apiResult
     * @param BaseResource $resource
     *
     * @return BaseResource
     */
    public static function createResourceFromApiResult(object $apiResult, BaseResource $resource): BaseResource
    {
        foreach ($apiResult as $property => $value) {
            $resource->{$property} = $value;
        }

        return $resource;
    }

    /**
     * @param \Vatly\API\VatlyApiClient $client
     * @param array $input
     * @param string $resourceClass
     * @param object|null $_links
     * @param string|null $resourcePageClass
     * @return mixed
     */
    public static function createCursorResourcePage(
        VatlyApiClient $client,
        array $input,
        string $resourceClass,
        ?object $_links = null,
        ?string $resourcePageClass = null
    ) {
        if (null === $resourcePageClass) {
            $resourcePageClass = $resourceClass.'Page';
        }

        $data = new $resourcePageClass($client, count($input), $_links);
        foreach ($input as $item) {
            $data[] = static::createResourceFromApiResult($item, new $resourceClass($client));
        }

        return $data;
    }
}
