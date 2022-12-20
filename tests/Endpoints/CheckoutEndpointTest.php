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
        $returnObject->id = "checkout_dummy_id";
        $this->httpClient->setSendReturnObject($returnObject);

        $checkout = $this->client->checkouts->create([
            'profileId' => 'profile_123', // TODO check if this is required at this moment
            'products' => [ // list of one-off-product IDs and subscription plan IDs
                [
                    'id' => 'one_off_product_abc_987',
                ],
                [
                    'id' => 'one_off_product_xyz_123',
                    // optional product overrides would go here, i.e. price, quantity
                ],
            ],
            'redirectUrlSuccess' => 'https://www.sandorian.com/success',
            'redirectUrlCanceled' => 'https://www.sandorian.com/canceled',
            //'metadata' // optional
            //'webhookUrls' => [], // optional
        ], [
            //
        ]);

        $this->assertInstanceOf(Checkout::class, $checkout);
        $this->assertEquals("checkout_dummy_id", $checkout->id);

        $this->assertWasSentOnly(
            VatlyApiClient::HTTP_POST,
            "https://api.vatly.com/v1/checkouts",
            [],
            '{
                        "profileId":"profile_123",
                        "products": [
                            {
                                "id": "one_off_product_abc_987"
                            },
                            {
                                "id": "one_off_product_xyz_123"
                            }
                        ],
                        "redirectUrlSuccess":"https://www.sandorian.com/success",
                        "redirectUrlCanceled":"https://www.sandorian.com/canceled"
                    }'
        );
    }

    /** @test */
    public function can_get_checkout()
    {
        $this->markTestSkipped('TBI');
    }
}
