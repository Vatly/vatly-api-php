# Customers

Customers represent the end-users who purchase your products. A customer is automatically created when they complete a checkout.

## Retrieve a Customer

```php
$customer = $vatly->customers->get('cus_abc123');

echo $customer->id;
echo $customer->email;
echo $customer->billingAddress->country;
```

## List Customers

```php
$customers = $vatly->customers->list();

foreach ($customers as $customer) {
    echo $customer->email;
}

// With pagination
$customers = $vatly->customers->list([
    'limit' => 50,
    'startingAfter' => 'cus_last_id',
]);
```

## Customer Subscriptions

```php
// Get all subscriptions for a customer
$subscriptions = $vatly->customers->subscriptions('cus_abc123')->list();

foreach ($subscriptions as $subscription) {
    echo $subscription->status;
}

// Get a specific subscription
$subscription = $vatly->customers->subscriptions('cus_abc123')->get('sub_xyz789');
```

## Customer Object

| Property | Type | Description |
|----------|------|-------------|
| `id` | string | Unique identifier (`cus_...`) |
| `email` | string | Customer email address |
| `billingAddress` | Address | Billing address details |
| `vatNumber` | string\|null | VAT/Tax ID if provided |
| `testmode` | bool | Whether this is a test customer |
| `createdAt` | string | Creation timestamp (ISO 8601) |

## Billing Address

| Property | Type | Description |
|----------|------|-------------|
| `country` | string | ISO 3166-1 alpha-2 country code |
| `city` | string\|null | City |
| `postalCode` | string\|null | Postal/ZIP code |
| `streetAndNumber` | string\|null | Street address |
| `companyName` | string\|null | Company name (B2B) |
