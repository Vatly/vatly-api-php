<?php

declare(strict_types=1);

namespace Vatly\API\Resources;

use Vatly\API\VatlyApiClient;

abstract class BaseResource
{
    /**
     * @var \Vatly\API\VatlyApiClient
     */
    protected VatlyApiClient $apiClient;

    public function __construct(VatlyApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }
}
