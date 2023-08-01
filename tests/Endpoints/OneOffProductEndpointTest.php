<?php

namespace Vatly\Tests\Endpoints;

use Vatly\API\Resources\OneOffProduct;
use Vatly\API\Resources\OneOffProductCollection;

class OneOffProductEndpointTest extends BaseEndpointTest
{
    /** @test */
    public function can_get_one_off_product()
    {
        $productId = 'one_off_product_78b146a7de7d417e9d68d7e6ef193d18';

        $responseBodyArray = [
            'id' => $productId,
            'resource' => 'one_off_product',
            'name' => 'Test product',
            'description' => 'Test product description',
            'basePrice' => [
                'value' => '10.00',
                'currency' => 'EUR',
            ],
            '_links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL. '/one-off-products/' . $productId,
                    'type' => 'application/hal+json',
                ],
            ],
        ];

        $this->httpClient->setSendReturnObjectFromArray($responseBodyArray);

        /** @var OneOffProduct $product */
        $product = $this->client->oneOffProducts->get($productId);

        $this->assertEquals($productId, $product->id);
        $this->assertEquals('one_off_product', $product->resource);
        $this->assertEquals('Test product', $product->name);
        $this->assertEquals('Test product description', $product->description);
        $this->assertEquals('10.00', $product->basePrice->value);
        $this->assertEquals('EUR', $product->basePrice->currency);

        $this->assertEquals(self::API_ENDPOINT_URL. '/one-off-products/' . $productId, $product->_links->self->href);
        $this->assertEquals('application/hal+json', $product->_links->self->type);
    }

    /** @test */
    public function can_list_one_off_products()
    {
        $responseBodyArray = [
            'count' => 2,
            '_embedded' => [
                'one_off_products' => [
                    [
                        'id' => 'one_off_product_123',
                        'resource' => 'one_off_product',
                    ],
                    [
                        'id' => 'one_off_product_456',
                        'resource' => 'one_off_product',
                    ],
                ],
            ],
            '_links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL.'/one-off-products',
                    'type' => 'application/hal+json',
                ],
                'next' => [
                    'href' => self::API_ENDPOINT_URL.'/one-off-products?from=one_off_product_next_dummy_id',
                    'type' => 'application/hal+json',
                ],
                'previous' => [
                    'href' => self::API_ENDPOINT_URL.'/one-off-products?to=one_off_product_previous_dummy_id',
                    'type' => 'application/hal+json',
                ],
            ],
        ];


        $this->httpClient->setSendReturnObjectFromArray($responseBodyArray);

        $productCollection = $this->client->oneOffProducts->page();

        $this->assertEquals(2, $productCollection->count);
        $this->assertCount(2, $productCollection);
        $this->assertInstanceOf(OneOffProductCollection::class, $productCollection);
        $this->assertInstanceOf(OneOffProduct::class, $productCollection[0]);
        $this->assertInstanceOf(OneOffProduct::class, $productCollection[1]);

        $this->assertEquals('one_off_product_123', $productCollection[0]->id);
        $this->assertEquals('one_off_product_456', $productCollection[1]->id);

        $this->assertEquals(self::API_ENDPOINT_URL.'/one-off-products', $productCollection->_links->self->href);
        $this->assertEquals('application/hal+json', $productCollection->_links->self->type);
        $this->assertEquals(self::API_ENDPOINT_URL.'/one-off-products?from=one_off_product_next_dummy_id', $productCollection->_links->next->href);
        $this->assertEquals('application/hal+json', $productCollection->_links->next->type);
        $this->assertEquals(self::API_ENDPOINT_URL.'/one-off-products?to=one_off_product_previous_dummy_id', $productCollection->_links->previous->href);
        $this->assertEquals('application/hal+json', $productCollection->_links->previous->type);
    }

    /** @test */
    public function can_get_next_page_of_one_off_products()
    {
        $responseBodyArray = [
            'count' => 2,
            '_embedded' => [
                'one_off_products' => [
                    [
                        'id' => 'one_off_product_123',
                        'resource' => 'one_off_product',
                    ],
                    [
                        'id' => 'one_off_product_456',
                        'resource' => 'one_off_product',
                    ],
                ],
            ],
            '_links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL . '/one-off-products',
                    'type' => 'application/hal+json',
                ],
                'next' => [
                    'href' => self::API_ENDPOINT_URL . '/one-off-products?from=one_off_product_next_dummy_id',
                    'type' => 'application/hal+json',
                ],
                'previous' => null,
            ],
        ];

        $this->httpClient->setSendReturnObjectFromArray($responseBodyArray);

        $productCollection = $this->client->oneOffProducts->page();

        $nextResponseBodyArray = [
            'count' => 1,
            '_embedded' => [
                'one_off_products' => [
                    [
                        'id' => 'one_off_product_789',
                        'resource' => 'one_off_product',
                    ],
                ],
            ],
            '_links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL . '/one-off-products?from=one_off_product_next_dummy_id',
                    'type' => 'application/hal+json',
                ],
                'next' => null,
                'previous' => [
                    'href' => self::API_ENDPOINT_URL . '/one-off-products',
                    'type' => 'application/hal+json',
                ],
            ],
        ];

        $this->httpClient->setSendReturnObjectFromArray($nextResponseBodyArray);

        $nextProductCollection = $productCollection->next();

        $this->assertEquals(1, $nextProductCollection->count);
        $this->assertCount(1, $nextProductCollection);
        $this->assertInstanceOf(OneOffProductCollection::class, $nextProductCollection);

        $product = $nextProductCollection[0];
        $this->assertInstanceOf(OneOffProduct::class, $product);
        $this->assertEquals('one_off_product_789', $product->id);

        $this->assertNull($nextProductCollection->next());
    }
}
