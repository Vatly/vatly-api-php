<?php

namespace Vatly\Tests\Endpoints;

use Vatly\API\Resources\Customer;
use Vatly\API\Resources\CustomerCollection;
use Vatly\API\VatlyApiClient;

class CustomersEndpointTest extends BaseEndpointTest
{
    /** @test */
    public function it_can_create_a_customer(): void
    {
        $responseBodyArray = [
            'id' => 'customer_78b146a7de7d417e9d68d7e6ef193d18',
            'resource' => 'customer',
            'name' => 'Test customer',
            'streetAndNumber' => 'Test street 1',
            'streetAdditional' => 'Test street 2',
            'postalCode' => '12345',
            'city' => 'Test city',
            'country' => 'DE',
            'companyName' => 'Test company',
            'vatNumber' => 'DE123456789',
            'email' => 'testcustomer@dummy.com',
            'locale' => 'de_DE',
            'createdAt' => '2020-01-01T00:00:00+00:00',
            'testmode' => true,
            'metadata' => [
                'customer_id' => '123456',
            ],
            'links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL. '/customers/customer_78b146a7de7d417e9d68d7e6ef193d18',
                    'type' => 'application/hal+json',
                ],
            ],
        ];

        $this->httpClient->setSendReturnObjectFromArray($responseBodyArray);

        /** @var Customer $customer */
        $customer = $this->client->customers->create([
            'name' => 'Test customer',
            'street_and_number' => 'Test street 1',
            'street_additional' => 'Test street 2',
            'postal_code' => '12345',
            'city' => 'Test city',
            'country' => 'DE',
            'company_name' => 'Test company',
            'vat_number' => 'DE123456789',
            'email' => 'testcustomer@dummy.com',
            'locale' => 'de_DE',
            'metadata' => [
                'customer_id' => '123456',
            ],
        ]);

        $this->assertWasSentOnly(
            VatlyApiClient::HTTP_POST,
            self::API_ENDPOINT_URL."/customers",
            [],
            '{"name":"Test customer","street_and_number":"Test street 1","street_additional":"Test street 2","postal_code":"12345","city":"Test city","country":"DE","company_name":"Test company","vat_number":"DE123456789","email":"testcustomer@dummy.com","locale":"de_DE","metadata":{"customer_id":"123456"}}'
        );

        $this->assertEquals('customer_78b146a7de7d417e9d68d7e6ef193d18', $customer->id);
        $this->assertEquals('customer', $customer->resource);
        $this->assertEquals('Test customer', $customer->name);
        $this->assertEquals('Test street 1', $customer->streetAndNumber);
        $this->assertEquals('Test street 2', $customer->streetAdditional);
        $this->assertEquals('12345', $customer->postalCode);
        $this->assertEquals('Test city', $customer->city);
        $this->assertEquals('DE', $customer->country);
        $this->assertEquals('Test company', $customer->companyName);
        $this->assertEquals('DE123456789', $customer->vatNumber);
        $this->assertEquals('testcustomer@dummy.com', $customer->email);
        $this->assertEquals('de_DE', $customer->locale);
        $this->assertEquals('2020-01-01T00:00:00+00:00', $customer->createdAt);
        $this->assertTrue($customer->testmode);
        $this->assertEquals(['customer_id' => '123456'], (array) $customer->metadata);
        $this->assertEquals(self::API_ENDPOINT_URL. '/customers/customer_78b146a7de7d417e9d68d7e6ef193d18', $customer->links->self->href);
        $this->assertEquals('application/hal+json', $customer->links->self->type);
    }

    /** @test */
    public function it_creates_customer_with_minimal_data(): void
    {
        $responseBodyArray = [
            'id' => 'customer_78b146a7de7d417e9d68d7e6ef193d18',
            'resource' => 'customer',
            'name' => 'Test customer',
            'createdAt' => '2020-01-01T00:00:00+00:00',
            'testmode' => true,
            'links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL. '/customers/customer_78b146a7de7d417e9d68d7e6ef193d18',
                    'type' => 'application/hal+json',
                ],
            ],
        ];

        $this->httpClient->setSendReturnObjectFromArray($responseBodyArray);

        /** @var Customer $customer */
        $customer = $this->client->customers->create([
            'name' => 'Test customer',
        ]);

        $this->assertWasSentOnly(
            VatlyApiClient::HTTP_POST,
            self::API_ENDPOINT_URL."/customers",
            [],
            '{"name":"Test customer"}'
        );

        $this->assertEquals('customer_78b146a7de7d417e9d68d7e6ef193d18', $customer->id);
        $this->assertEquals('customer', $customer->resource);
        $this->assertEquals('Test customer', $customer->name);
        $this->assertEquals('2020-01-01T00:00:00+00:00', $customer->createdAt);
        $this->assertTrue($customer->testmode);
        $this->assertEquals(self::API_ENDPOINT_URL. '/customers/customer_78b146a7de7d417e9d68d7e6ef193d18', $customer->links->self->href);
        $this->assertEquals('application/hal+json', $customer->links->self->type);
        $this->assertNull($customer->streetAndNumber);
        $this->assertNull($customer->streetAdditional);
        $this->assertNull($customer->postalCode);
        $this->assertNull($customer->city);
        $this->assertNull($customer->country);
        $this->assertNull($customer->companyName);
        $this->assertNull($customer->vatNumber);
        $this->assertNull($customer->email);
        $this->assertNull($customer->locale);
        $this->assertNull($customer->metadata);
    }

    /** @test */
    public function it_can_get_a_customer(): void
    {
        $responseBodyArray = [
            'id' => 'customer_78b146a7de7d417e9d68d7e6ef193d18',
            'resource' => 'customer',
            'name' => 'Test customer',
            'streetAndNumber' => 'Test street 1',
            'streetAdditional' => 'Test street 2',
            'postalCode' => '12345',
            'city' => 'Test city',
            'country' => 'DE',
            'companyName' => 'Test company',
            'vatNumber' => 'DE123456789',
            'email' => 'testcustomer@dummy.com',
            'locale' => 'de_DE',
            'createdAt' => '2020-01-01T00:00:00+00:00',
            'testmode' => true,
            'metadata' => [
                'customer_id' => '123456',
            ],
            'links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL . '/customers/customer_78b146a7de7d417e9d68d7e6ef193d18',
                    'type' => 'application/hal+json',
                ],
            ],
        ];

        $this->httpClient->setSendReturnObjectFromArray($responseBodyArray);

        /** @var Customer $customer */
        $customer = $this->client->customers->get('customer_78b146a7de7d417e9d68d7e6ef193d18');

        $this->assertEquals('customer_78b146a7de7d417e9d68d7e6ef193d18', $customer->id);
        $this->assertEquals('customer', $customer->resource);
        $this->assertEquals('Test customer', $customer->name);
        $this->assertEquals('Test street 1', $customer->streetAndNumber);
    }

    /** @test */
    public function can_get_customers_list(): void
    {
        $responseBodyArray = [
            'count' => 2,
            'data' => [
                [
                    'id' => 'customer_78b146a7de7d417e9d68d7e6ef193d18',
                    'resource' => 'customer',
                    'name' => 'Test customer',
                    'streetAndNumber' => 'Test street 1',
                    'streetAdditional' => 'Test street 2',
                    'postalCode' => '12345',
                    'city' => 'Test city',
                    'country' => 'DE',
                    'companyName' => 'Test company',
                    'vatNumber' => 'DE123456789',
                    'email' => 'testcustomer@dummy.com',
                    'locale' => 'de_DE',
                    'createdAt' => '2020-01-01T00:00:00+00:00',
                    'testmode' => true,
                    'metadata' => [
                        'customer_id' => '123456',
                    ],
                    'links' => [
                        'self' => [
                            'href' => self::API_ENDPOINT_URL . '/customers/customer_78b146a7de7d417e9d68d7e6ef193d18',
                            'type' => 'application/hal+json',
                        ],
                    ],
                ],
                [
                    'id' => 'customer_78b146a7de7d417e9d68d7e6ef193d19',
                    'resource' => 'customer',
                    'name' => 'Test customer 2',
                    'email' => 'johndoe@example.com',
                    'createdAt' => '2020-01-01T00:00:00+00:00',
                    'testmode' => true,
                    'metadata' => null,
                    'links' => [
                        'self' => [
                            'href' => self::API_ENDPOINT_URL . '/customers/customer_78b146a7de7d417e9d68d7e6ef193d19',
                            'type' => 'application/hal+json',
                        ],
                    ],
                ],
            ],
            'links' => [
                'self' => [
                    'href' => self::API_ENDPOINT_URL . '/customers',
                    'type' => 'application/hal+json',
                ],
                'next' => [
                    'href' => self::API_ENDPOINT_URL . '/customers?starting_after=customer_78b146a7de7d417e9d68d7e6ef193d19',
                    'type' => 'application/hal+json',
                ],
                'previous' => [
                    'href' => self::API_ENDPOINT_URL . '/customers?ending_before=customer_78b146a7de7d417e9d68d7e6ef193d18',
                    'type' => 'application/hal+json',
                ],
            ],

        ];

        $this->httpClient->setSendReturnObjectFromArray($responseBodyArray);

        /** @var CustomerCollection $customers */
        $customers = $this->client->customers->page();

        $this->assertEquals(2, $customers->count);
        $this->assertEquals(self::API_ENDPOINT_URL . '/customers', $customers->links->self->href);
        $this->assertEquals('application/hal+json', $customers->links->self->type);

        $customer1 = $customers[0];
        $this->assertEquals('customer_78b146a7de7d417e9d68d7e6ef193d18', $customer1->id);
        $this->assertEquals('customer', $customer1->resource);
        $this->assertEquals('Test customer', $customer1->name);
        $this->assertEquals('Test street 1', $customer1->streetAndNumber);

        $customer2 = $customers[1];
        $this->assertEquals('customer_78b146a7de7d417e9d68d7e6ef193d19', $customer2->id);
        $this->assertEquals('customer', $customer2->resource);
        $this->assertEquals('Test customer 2', $customer2->name);
        $this->assertEquals('johndoe@example.com', $customer2->email);

        $this->assertEquals(self::API_ENDPOINT_URL . '/customers/customer_78b146a7de7d417e9d68d7e6ef193d18', $customer1->links->self->href);
        $this->assertEquals(self::API_ENDPOINT_URL . '/customers/customer_78b146a7de7d417e9d68d7e6ef193d19', $customer2->links->self->href);
        $this->assertEquals(self::API_ENDPOINT_URL . '/customers?starting_after=customer_78b146a7de7d417e9d68d7e6ef193d19', $customers->links->next->href);
        $this->assertEquals(self::API_ENDPOINT_URL . '/customers?ending_before=customer_78b146a7de7d417e9d68d7e6ef193d18', $customers->links->previous->href);
    }

    /** @test */
    public function can_get_next_page():void
    {
        $responseBodyArrayCollection = [
            [
                'count' => 1,
                'data' => [
                    ['id' => 'customer_78b146a7de7d417e9d68d7e6ef193d18', 'resource' => 'customer'],
                ],
                'links' => [
                    'self' => [
                        'href' => self::API_ENDPOINT_URL . '/customers',
                        'type' => 'application/hal+json',
                    ],
                    'next' => [
                        'href' => self::API_ENDPOINT_URL . '/customers?starting_after=customer_78b146a7de7d417e9d68d7e6ef193d18',
                        'type' => 'application/hal+json',
                    ],
                    'previous' => [
                        'href' => self::API_ENDPOINT_URL . '/customers?ending_before=customer_previous_id',
                        'type' => 'application/hal+json',
                    ],
                ],
            ],
            [
                'count' => 1,
                'data' => [
                    [
                        'id' => 'customer_78b146a7de7d417e9d68d7e6ef193d19',
                        'resource' => 'customer',
                        'name' => 'Test customer 2',
                        'email' => 'me@me.com',
                        'createdAt' => '2020-01-01T00:00:00+00:00',
                        'testmode' => true,
                        'metadata' => null,
                        'links' => [
                            'self' => [
                                'href' => self::API_ENDPOINT_URL . '/customers/customer_78b146a7de7d417e9d68d7e6ef193d19',
                                'type' => 'application/hal+json',
                            ],
                        ],
                    ],
                ],
                'links' => [
                    'self' => [
                        'href' => self::API_ENDPOINT_URL . '/customers?starting_after=customer_78b146a7de7d417e9d68d7e6ef193d18',
                        'type' => 'application/hal+json',
                    ],
                    'next' => null,
                    'previous' => [
                        'href' => self::API_ENDPOINT_URL . '/customers?ending_before=customer_78b146a7de7d417e9d68d7e6ef193d18',
                        'type' => 'application/hal+json',
                    ],
                ],
            ],
        ];

        $this->httpClient->setSendReturnCollectionFromArray($responseBodyArrayCollection);

        /** @var CustomerCollection $customers */
        $customers = $this->client->customers->page();

        /** @var CustomerCollection $nextCustomers */
        $nextCustomers = $customers->next();

        $this->assertWasSent(
            VatlyApiClient::HTTP_GET,
            self::API_ENDPOINT_URL . '/customers?starting_after=customer_78b146a7de7d417e9d68d7e6ef193d18',
            [],
            null,
        );

        $customer = $nextCustomers[0];

        $this->assertEquals(1, $nextCustomers->count);
        $this->assertEquals(self::API_ENDPOINT_URL . '/customers?starting_after=customer_78b146a7de7d417e9d68d7e6ef193d18', $nextCustomers->links->self->href);
        $this->assertEquals('application/hal+json', $nextCustomers->links->self->type);
        $this->assertNull($nextCustomers->next());

        $this->assertEquals('customer_78b146a7de7d417e9d68d7e6ef193d19', $customer->id);
        $this->assertEquals('customer', $customer->resource);
        $this->assertEquals('Test customer 2', $customer->name);
        $this->assertEquals('me@me.com', $customer->email);
        $this->assertEquals('2020-01-01T00:00:00+00:00', $customer->createdAt);
        $this->assertTrue($customer->testmode);
        $this->assertEquals(null, $customer->metadata);
        $this->assertEquals(self::API_ENDPOINT_URL . '/customers/customer_78b146a7de7d417e9d68d7e6ef193d19', $customer->links->self->href);
        $this->assertEquals('application/hal+json', $customer->links->self->type);
    }
}
