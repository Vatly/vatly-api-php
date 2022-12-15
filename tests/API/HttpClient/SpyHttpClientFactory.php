<?php

declare(strict_types=1);

namespace Vatly\Tests\API\HttpClient;

use Vatly\API\HttpClient\HttpClientInterface;

class SpyHttpClientFactory implements \Vatly\API\HttpClient\HttpClientFactoryInterface
{
    /**
     * @var \Vatly\Tests\API\HttpClient\SpyHttpClient
     */
    protected SpyHttpClient $httpClient;

    public function __construct(SpyHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function make(): HttpClientInterface
    {
        return $this->httpClient;
    }
}
