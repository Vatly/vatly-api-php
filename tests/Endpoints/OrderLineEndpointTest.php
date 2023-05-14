<?php

namespace Vatly\Tests\Endpoints;

use Vatly\API\Resources\OrderLine;
use Vatly\API\Resources\OrderLineCollection;
use Vatly\API\VatlyApiClient;

class OrderLineEndpointTest extends BaseEndpointTest
{
    /** @test */
    public function it_can_get_order_list_items(): void
    {
        $orderId = 'order_66fc8a40718b46bea50f1a25f456d243';

        $responseBodyArray = [
            'count' => 1,
            '_embedded' => [
                'orderlines' => [
                    [
                        "id" => "order_item_2a46f4c01d3b47979f4d7b3f58c98be7",
                        "resource" => "orderline",
                        "orderId" => $orderId,
                        "description" => "PDF Book",
                        "quantity" => 1,
                        "basePrice" => [
                            "value" => "80.00",
                            "currency" => "EUR",
                        ],
                        "total" => [
                            "value" => "100.00",
                            "currency" => "EUR",
                        ],
                        "taxAmount" => [
                            "value" => "20.00",
                            "currency" => "EUR",
                        ],
                        "subtotal" => [
                            "value" => "80.00",
                            "currency" => "EUR",
                        ],
                        "taxName" => "VAT",
                        "taxPercentage" => "20.00",
                        '_links' => [
                            'self' => [
                                'href' => self::API_ENDPOINT_URL.'/orders/'.$orderId.'/lines/order_item_2a46f4c01d3b47979f4d7b3f58c98be7',
                                'type' => 'application/hal+json',
                            ],
                            'order' => [
                                'href' => self::API_ENDPOINT_URL.'/orders/'.$orderId,
                                'type' => 'application/hal+json',
                            ],
                        ],
                    ],
                ],
            ],
            '_links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL.'/orders/'.$orderId.'/lines/',
                    'type' => 'application/hal+json',
                ],
            ],
        ];

        $this->httpClient->setSendReturnObjectFromArray($responseBodyArray);
        /** @var OrderLineCollection $orderLines */
        $orderLines = $this->client->orderLines->page($orderId);

        /** @var OrderLine $orderLine */
        $orderLine = $orderLines[0];

        $this->assertEquals($orderId, $orderLine->orderId);
        $this->assertEquals('order_item_2a46f4c01d3b47979f4d7b3f58c98be7', $orderLine->id);
        $this->assertEquals('orderline', $orderLine->resource);
        $this->assertEquals('PDF Book', $orderLine->description);
        $this->assertEquals(1, $orderLine->quantity);
        $this->assertEquals('80.00', $orderLine->basePrice->value);
        $this->assertEquals('EUR', $orderLine->basePrice->currency);
        $this->assertEquals('100.00', $orderLine->total->value);
        $this->assertEquals('EUR', $orderLine->total->currency);
        $this->assertEquals('20.00', $orderLine->taxAmount->value);
        $this->assertEquals('EUR', $orderLine->taxAmount->currency);
        $this->assertEquals('80.00', $orderLine->subtotal->value);
        $this->assertEquals('EUR', $orderLine->subtotal->currency);
        $this->assertEquals('VAT', $orderLine->taxName);
        $this->assertEquals('20.00', $orderLine->taxPercentage);
        $this->assertEquals(self::API_ENDPOINT_URL.'/orders/'.$orderId.'/lines/order_item_2a46f4c01d3b47979f4d7b3f58c98be7', $orderLine->_links->self->href);
        $this->assertEquals('application/hal+json', $orderLine->_links->self->type);
        $this->assertEquals(self::API_ENDPOINT_URL.'/orders/'.$orderId, $orderLine->_links->order->href);
        $this->assertEquals('application/hal+json', $orderLine->_links->order->type);

        $this->assertNull($orderLines->get("bad_id"));
        $this->assertInstanceOf(OrderLine::class, $orderLines->get("order_item_2a46f4c01d3b47979f4d7b3f58c98be7"));
    }

    /** @test */
    public function can_get_an_order_line():void
    {
        $orderId = 'order_66fc8a40718b46bea50f1a25f456d243';

        $responseBodyArray = [
            "id" => "order_item_2a46f4c01d3b47979f4d7b3f58c98be7",
            "resource" => "orderline",
            "orderId" => $orderId,
            "description" => "PDF Book",
            "quantity" => 1,
            "basePrice" => [
                "value" => "80.00",
                "currency" => "EUR",
            ],
            "total" => [
                "value" => "100.00",
                "currency" => "EUR",
            ],
            "taxAmount" => [
                "value" => "20.00",
                "currency" => "EUR",
            ],
            "subtotal" => [
                "value" => "80.00",
                "currency" => "EUR",
            ],
            "taxName" => "VAT",
            "taxPercentage" => "20.00",
            '_links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL.'/order/'.$orderId.'/line/order_item_2a46f4c01d3b47979f4d7b3f58c98be7',
                    'type' => 'application/hal+json',
                ],
                'order' => [
                    'href' => self::API_ENDPOINT_URL.'/order/'.$orderId,
                    'type' => 'application/hal+json',
                ],
            ],
        ];

        $this->httpClient->setSendReturnObjectFromArray($responseBodyArray);

        /** @var OrderLine $orderLine */
        $orderLine = $this->client->orderLines->get($orderId, 'order_item_2a46f4c01d3b47979f4d7b3f58c98be7');

        $this->assertWasSent(
            VatlyApiClient::HTTP_GET,
            self::API_ENDPOINT_URL.'/orders/'.$orderId.'/lines/order_item_2a46f4c01d3b47979f4d7b3f58c98be7',
            [],
            null,
        );

        $this->assertEquals($orderId, $orderLine->orderId);
        $this->assertEquals('order_item_2a46f4c01d3b47979f4d7b3f58c98be7', $orderLine->id);
        $this->assertEquals('orderline', $orderLine->resource);
        $this->assertEquals('PDF Book', $orderLine->description);
        $this->assertEquals(1, $orderLine->quantity);
        $this->assertEquals('80.00', $orderLine->basePrice->value);
        $this->assertEquals('EUR', $orderLine->basePrice->currency);
        $this->assertEquals('100.00', $orderLine->total->value);
        $this->assertEquals('EUR', $orderLine->total->currency);
        $this->assertEquals('20.00', $orderLine->taxAmount->value);
        $this->assertEquals('EUR', $orderLine->taxAmount->currency);
        $this->assertEquals('80.00', $orderLine->subtotal->value);
        $this->assertEquals('EUR', $orderLine->subtotal->currency);
        $this->assertEquals('VAT', $orderLine->taxName);
        $this->assertEquals('20.00', $orderLine->taxPercentage);
        $this->assertEquals(self::API_ENDPOINT_URL.'/order/'.$orderId.'/line/order_item_2a46f4c01d3b47979f4d7b3f58c98be7', $orderLine->_links->self->href);
        $this->assertEquals('application/hal+json', $orderLine->_links->self->type);
        $this->assertEquals(self::API_ENDPOINT_URL.'/order/'.$orderId, $orderLine->_links->order->href);
        $this->assertEquals('application/hal+json', $orderLine->_links->order->type);
    }
}
