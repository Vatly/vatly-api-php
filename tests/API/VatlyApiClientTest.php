<?php

declare(strict_types=1);

namespace Vatly\Tests\API;

use Vatly\API\HttpClient\CurlHttpClient;
use Vatly\API\VatlyApiClient;
use Vatly\Tests\BaseTestCase;

class VatlyApiClientTest extends BaseTestCase
{
    /** @test */
    public function itWiresUpACurlHttpClientWhenNoFactoryIsProvided()
    {
        $client = new VatlyApiClient;

        $this->assertInstanceOf(CurlHttpClient::class, $client->getHttpClient());
    }
}
