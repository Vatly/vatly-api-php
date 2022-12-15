<?php

declare(strict_types=1);

namespace Vatly\Tests;

use PHPUnit\Framework\TestCase;
use Vatly\API\VatlyApiClient;
use Vatly\Tests\API\HttpClient\SpyHttpClient;
use Vatly\Tests\API\HttpClient\SpyHttpClientFactory;

abstract class BaseTestCase extends TestCase
{
    /**
     * @var \Vatly\Tests\API\HttpClient\SpyHttpClient
     */
    protected SpyHttpClient $httpClient;

    /**
     * @var \Vatly\API\VatlyApiClient
     */
    protected VatlyApiClient $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClient = new SpyHttpClient;
        $this->client = new VatlyApiClient(new SpyHttpClientFactory($this->httpClient));
    }

    public function assertWasSent(
        string $httpMethod,
        string $url,
        array $headers,
        string $httpBody
    ): void {
        $message = 'Expected message was not sent.';

        $this->assertTrue(
            $this->httpClient->wasSent(
                $httpMethod,
                $url,
                $headers,
                $httpBody,
            ),
            $message,
        );
    }
}
