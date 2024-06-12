<?php

declare(strict_types=1);

namespace Vatly\Tests\API;

use Vatly\API\HttpClient\CurlHttpClient;
use Vatly\API\VatlyApiClient;
use Vatly\Tests\BaseTestCase;

class VatlyApiClientTest extends BaseTestCase
{
    /** @test */
    public function itWiresUpACurlHttpClientWhenNoFactoryIsProvided(): void
    {
        $client = new VatlyApiClient;

        $this->assertInstanceOf(CurlHttpClient::class, $client->getHttpClient());
    }

    /** @test */
    public function setApiKeyAcceptsPipeCharacters(): void
    {
        $client = new VatlyApiClient;

        $client->setApiKey('test_1|dummy_key_with_pipe_character');

        $this->assertTrue(true); // Just making sure we don't get an exception in this test
    }
}
