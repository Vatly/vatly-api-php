<?php

declare(strict_types=1);

namespace Vatly\Tests\Endpoints;

use Vatly\API\Resources\Checkout;
use Vatly\API\Resources\CheckoutCollection;
use Vatly\API\VatlyApiClient;

class CheckoutEndpointTest extends BaseEndpointTest
{
    /** @test */
    public function can_create_checkout()
    {
        $responseBodyArray = [
            'id' => "checkout_dummy_id",
            'resource' => 'checkout',
            'merchantId' => 'merchant_123',
            'profileId' => 'profile_123',
            'orderId' => 'order_123',
            'testmode' => true,
            'redirectUrlSuccess' => 'https://www.sandorian.com/success',
            'redirectUrlCanceled' => 'https://www.sandorian.com/canceled',
            'metadata' => [
                'order_id' => '123456',
            ],
            '_links' => [
                'checkoutUrl' => [
                    'href' => self::API_ENDPOINT_URL.'/checkout/checkout_dummy_id',
                    'type' => 'text/html',
                ],
                'self' => [
                    'href' => self::API_ENDPOINT_URL.'/checkouts/checkout_dummy_id',
                    'type' => 'application/json',
                ],
            ],
        ];

        $this->httpClient->setSendReturnObject($responseBodyArray);

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
            'testmode' => true,
            'metadata' => ['order_id' => '123456'], // optional
            //'webhookUrls' => [], // optional
        ], [
            //
        ]);

        $this->assertInstanceOf(Checkout::class, $checkout);
        $this->assertEquals("checkout_dummy_id", $checkout->id);
        $this->assertEquals("profile_123", $checkout->profileId);
        $this->assertEquals("merchant_123", $checkout->merchantId);
        $this->assertEquals("order_123", $checkout->orderId);
        $this->assertEquals("checkout", $checkout->resource);
        $this->assertEquals("https://www.sandorian.com/success", $checkout->redirectUrlSuccess);
        $this->assertEquals("https://www.sandorian.com/canceled", $checkout->redirectUrlCanceled);
        $this->assertTrue($checkout->testmode);
        $this->assertEquals(self::API_ENDPOINT_URL.'/checkout/checkout_dummy_id', $checkout->_links->checkoutUrl->href);
        $this->assertEquals(self::API_ENDPOINT_URL.'/checkouts/checkout_dummy_id', $checkout->_links->self->href);
        $this->assertEquals($responseBodyArray['metadata'], (array) $checkout->metadata);

        $this->assertWasSentOnly(
            VatlyApiClient::HTTP_POST,
            self::API_ENDPOINT_URL."/checkouts",
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
                        "redirectUrlCanceled":"https://www.sandorian.com/canceled",
                        "testmode":true,
                        "metadata": {
                            "order_id": "123456"
                        }
                    }'
        );
    }

    /** @test */
    public function can_get_checkout()
    {
        $responseBodyArray = [
            'id' => "checkout_dummy_id",
            'resource' => 'checkout',
            'merchantId' => 'merchant_123',
            'profileId' => 'profile_123',
            'orderId' => 'order_123',
            'testmode' => true,
            'redirectUrlSuccess' => 'https://www.sandorian.com/success',
            'redirectUrlCanceled' => 'https://www.sandorian.com/canceled',
            'metadata' => [
                'order_id' => '123456',
            ],
            'paymentMethod' => 'ideal',
            'paid' => true,
            'total' => 100_00,
            'subtotal' => 80_00,
            'vat' => "20.00",
            'tax' => 20_00,
            'currency' => 'EUR',
            '_links' => [
                'checkoutUrl' => [
                    'href' => self::API_ENDPOINT_URL.'/checkout/checkout_dummy_id',
                    'type' => 'text/html',
                ],
                'self' => [
                   'href' => self::API_ENDPOINT_URL.'/checkouts/checkout_dummy_id',
                   'type' => 'application/hal+json',
                ],
            ],
        ];

        $this->httpClient->setSendReturnObject($responseBodyArray);

        $checkout = $this->client->checkouts->get('checkout_dummy_id', []);

        $this->assertInstanceOf(Checkout::class, $checkout);
        $this->assertEquals("checkout_dummy_id", $checkout->id);
        $this->assertEquals("profile_123", $checkout->profileId);
        $this->assertEquals("merchant_123", $checkout->merchantId);
        $this->assertEquals("order_123", $checkout->orderId);
        $this->assertEquals("checkout", $checkout->resource);
        $this->assertEquals("https://www.sandorian.com/success", $checkout->redirectUrlSuccess);
        $this->assertEquals("https://www.sandorian.com/canceled", $checkout->redirectUrlCanceled);
        $this->assertTrue($checkout->testmode);
        $this->assertEquals(self::API_ENDPOINT_URL.'/checkout/checkout_dummy_id', $checkout->_links->checkoutUrl->href);
        $this->assertEquals(self::API_ENDPOINT_URL.'/checkouts/checkout_dummy_id', $checkout->_links->self->href);
        $this->assertEquals($responseBodyArray['metadata'],  (array) $checkout->metadata);
        $this->assertEquals(100_00, $checkout->total);
        $this->assertEquals(80_00, $checkout->subtotal);
        $this->assertEquals("20.00", $checkout->vat);
        $this->assertEquals("EUR", $checkout->currency);
        $this->assertTrue($checkout->paid);
        $this->assertEquals("ideal", $checkout->paymentMethod);
    }

    /** @test */
    public function can_get_checkouts_list()
    {
        $responseBodyArray = [
            'count' => 1,
            '_embedded' => [
                'checkouts' => [
                    [
                        'id' => "checkout_dummy_id",
                        'resource' => 'checkout',
                        'merchantId' => 'merchant_123',
                        'profileId' => 'profile_123',
                        'orderId' => 'order_123',
                        'testmode' => true,
                        'redirectUrlSuccess' => 'https://www.sandorian.com/success',
                        'redirectUrlCanceled' => 'https://www.sandorian.com/canceled',
                        'paymentMethod' => 'ideal',
                        'paid' => true,
                        'total' => 100_00,
                        'subtotal' => 80_00,
                        'vat' => "20.00",
                        'tax' => 20_00,
                        'currency' => 'EUR',
                        '_links' => [
                            'checkoutUrl' => [
                                'href' => self::API_ENDPOINT_URL.'/checkout/checkout_dummy_id',
                                'type' => 'text/html',
                            ],
                            'self' => [
                                'href' => self::API_ENDPOINT_URL.'/checkouts/checkout_dummy_id',
                                'type' => 'application/hal+json',
                            ],
                        ],
                    ],
                ],
            ],
            '_links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL.'/checkouts',
                    'type' => 'application/hal+json',
                ],
                'next' => [
                    'href' => self::API_ENDPOINT_URL.'/checkouts?from=checkout_next_dummy_id',
                    'type' => 'application/hal+json',
                ],
                'previous' => null,
            ],

        ];

        $this->httpClient->setSendReturnObject($responseBodyArray);

        $checkoutCollection = $this->client->checkouts->page();

        $this->assertInstanceOf(CheckoutCollection::class, $checkoutCollection);
        $this->assertNull($checkoutCollection->_links->previous);
        $this->assertEquals(self::API_ENDPOINT_URL.'/checkouts?from=checkout_next_dummy_id', $checkoutCollection->_links->next->href);
        $this->assertEquals(1, $checkoutCollection->count);

        $checkout = $checkoutCollection[0];
        $this->assertInstanceOf(Checkout::class, $checkout);
        $this->assertEquals("checkout_dummy_id", $checkout->id);
        $this->assertEquals("profile_123", $checkout->profileId);
        $this->assertEquals("merchant_123", $checkout->merchantId);
        $this->assertEquals("order_123", $checkout->orderId);
        $this->assertEquals("checkout", $checkout->resource);
        $this->assertEquals("https://www.sandorian.com/success", $checkout->redirectUrlSuccess);
        $this->assertEquals("https://www.sandorian.com/canceled", $checkout->redirectUrlCanceled);
        $this->assertTrue($checkout->testmode);
        $this->assertEquals(self::API_ENDPOINT_URL.'/checkout/checkout_dummy_id', $checkout->_links->checkoutUrl->href);
        $this->assertEquals(self::API_ENDPOINT_URL.'/checkouts/checkout_dummy_id', $checkout->_links->self->href);

        $this->assertEquals(100_00, $checkout->total);
        $this->assertEquals(80_00, $checkout->subtotal);
        $this->assertEquals("20.00", $checkout->vat);
        $this->assertEquals("EUR", $checkout->currency);
        $this->assertTrue($checkout->paid);
        $this->assertEquals("ideal", $checkout->paymentMethod);
    }
}
