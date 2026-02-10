# Vatly PHP SDK Documentation

Official PHP SDK for the Vatly API. Handle subscriptions, one-off payments, tax compliance, and billing for your SaaS.

## Installation

```bash
composer require vatly/vatly-api-php
```

## Quick Start

```php
use Vatly\Api\VatlyApiClient;

$vatly = new VatlyApiClient();
$vatly->setApiKey('live_your_api_key_here');

// Create a checkout
$checkout = $vatly->checkouts->create([
    'products' => [
        ['id' => 'plan_abc123', 'quantity' => 1]
    ],
    'redirectUrlSuccess' => 'https://yourapp.com/success',
    'redirectUrlCanceled' => 'https://yourapp.com/canceled',
]);

// Redirect customer to checkout
header('Location: ' . $checkout->getCheckoutUrl());
```

## API Keys

Get your API keys from the [Vatly Dashboard](https://my.vatly.com) under **Settings > API**.

- **Live keys** (`live_`) - Production transactions
- **Test keys** (`test_`) - Sandbox testing, no real charges

## Resources

- [Checkouts](./Checkouts.md) - Create hosted payment pages
- [Customers](./Customers.md) - Manage customer records
- [Subscriptions](./Subscriptions.md) - Recurring billing
- [Subscription Plans](./SubscriptionPlans.md) - Define subscription products
- [One-Off Products](./OneOffProducts.md) - Single purchase products
- [Orders](./Orders.md) - Transaction records
- [Refunds](./Refunds.md) - Process refunds
- [Chargebacks](./Chargebacks.md) - Handle disputes
- [Webhooks](./Webhooks.md) - Real-time event notifications

## Error Handling

```php
use Vatly\Api\Exceptions\ApiException;
use Vatly\Api\Exceptions\ValidationException;

try {
    $checkout = $vatly->checkouts->create([...]);
} catch (ValidationException $e) {
    // Invalid request parameters
    echo $e->getMessage();
    print_r($e->getErrors());
} catch (ApiException $e) {
    // API error (network, auth, etc.)
    echo $e->getMessage();
    echo $e->getStatusCode();
}
```

## Requirements

- PHP 8.1+
- cURL extension
- JSON extension
