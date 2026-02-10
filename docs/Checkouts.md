# Checkouts

Checkouts create hosted payment pages for your customers. When a checkout completes successfully, an Order is created.

## Create a Checkout

```php
$checkout = $vatly->checkouts->create([
    'products' => [
        [
            'id' => 'plan_abc123',      // Subscription plan or one-off product ID
            'quantity' => 1,
            'trialDays' => 14,          // Optional: trial period for subscriptions
        ]
    ],
    'redirectUrlSuccess' => 'https://yourapp.com/success',
    'redirectUrlCanceled' => 'https://yourapp.com/canceled',
    'customerId' => 'cus_xyz789',       // Optional: existing customer
    'metadata' => [                      // Optional: your custom data
        'user_id' => '12345',
    ],
]);

// Redirect to hosted checkout
$checkoutUrl = $checkout->getCheckoutUrl();
```

## Retrieve a Checkout

```php
$checkout = $vatly->checkouts->get('chk_abc123');

echo $checkout->id;
echo $checkout->status;        // created, paid, canceled, failed, expired
echo $checkout->getCheckoutUrl();

if ($checkout->isPaid()) {
    $orderId = $checkout->orderId;
}
```

## List Checkouts

```php
// Get all checkouts (paginated)
$checkouts = $vatly->checkouts->list();

foreach ($checkouts as $checkout) {
    echo $checkout->id . ': ' . $checkout->status;
}

// Pagination
$checkouts = $vatly->checkouts->list([
    'limit' => 25,
    'startingAfter' => 'chk_last_id',
]);
```

## Checkout Object

| Property | Type | Description |
|----------|------|-------------|
| `id` | string | Unique identifier (`chk_...`) |
| `status` | string | `created`, `paid`, `canceled`, `failed`, `expired` |
| `merchantId` | string | Your merchant ID |
| `orderId` | string\|null | Order ID (after successful payment) |
| `testmode` | bool | Whether this is a test checkout |
| `redirectUrlSuccess` | string | Success redirect URL |
| `redirectUrlCanceled` | string | Cancel redirect URL |
| `metadata` | array | Your custom metadata |
| `expiresAt` | string\|null | Expiration timestamp (ISO 8601) |
| `createdAt` | string | Creation timestamp (ISO 8601) |

## Checkout Statuses

| Status | Description |
|--------|-------------|
| `created` | Checkout is active, awaiting payment |
| `paid` | Payment successful, order created |
| `canceled` | Customer canceled the checkout |
| `failed` | Payment failed |
| `expired` | Checkout expired without completion |

## Helper Methods

```php
$checkout->isPaid();        // true if status is 'paid'
$checkout->isCanceled();    // true if status is 'canceled'
$checkout->isExpired();     // true if status is 'expired'
$checkout->getCheckoutUrl(); // Hosted checkout page URL
$checkout->getOrderId();    // Order ID (null if not paid)
```
