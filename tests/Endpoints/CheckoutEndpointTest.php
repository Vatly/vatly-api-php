<?php

declare(strict_types=1);

namespace Vatly\Tests\Endpoints;

use Vatly\API\Resources\Checkout;
use Vatly\API\VatlyApiClient;

class CheckoutEndpointTest extends BaseEndpointTest
{
    /** @test */
    public function can_create_checkout()
    {
        $returnObject = new Checkout($this->client);
        $this->httpClient->setSendReturnObject($returnObject);

        $this->client->checkouts->create([
            'profileId' => '',
            'products' => [],
            'redirectUrlSuccess' => '',
            'redirectUrlCanceled' => '',
            //'metadata' // optional
            //'webhookUrls' => [], // optional
        ], [
            //
        ]);

        $this->assertWasSent(
            VatlyApiClient::HTTP_POST,
            "https://api.vatly.com/v1/checkouts",
            [],
            '{
                        "profileId":"",
                        "products":[],
                        "redirectUrlSuccess":"",
                        "redirectUrlCanceled":""
                    }'
        );
    }

    /** @test */
    public function can_get_checkout()
    {
        $this->markTestSkipped('TBI');
    }
}
