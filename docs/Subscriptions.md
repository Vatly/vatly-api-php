# Subscriptions

Subscriptions represent recurring billing relationships with customers. Created automatically when a customer purchases a subscription plan via checkout.

## Retrieve a Subscription

```php
$subscription = $vatly->subscriptions->get('sub_abc123');

echo $subscription->id;
echo $subscription->status;
echo $subscription->renewedUntil;
```

## List Subscriptions

```php
$subscriptions = $vatly->subscriptions->list();

foreach ($subscriptions as $subscription) {
    echo $subscription->id . ': ' . $subscription->status;
}
```

## Cancel a Subscription

```php
// Cancel at end of billing period (recommended)
$subscription = $vatly->subscriptions->cancel('sub_abc123');

// Cancel immediately
$subscription = $vatly->subscriptions->cancel('sub_abc123', [
    'immediately' => true,
]);
```

## Update Billing Method

```php
// Get a link for customer to update their payment method
$link = $vatly->subscriptions->updateBilling('sub_abc123');

// Redirect customer to update their payment details
header('Location: ' . $link->url);
```

## Subscription Object

| Property | Type | Description |
|----------|------|-------------|
| `id` | string | Unique identifier (`sub_...`) |
| `status` | string | Current status (see below) |
| `customerId` | string | Customer ID |
| `planId` | string | Subscription plan ID |
| `quantity` | int | Number of units |
| `basePrice` | Money | Price per unit |
| `interval` | string | `month` or `year` |
| `intervalCount` | int | Billing frequency |
| `startedAt` | string | Start timestamp |
| `renewedAt` | string\|null | Last renewal timestamp |
| `renewedUntil` | string\|null | Current period end |
| `canceledAt` | string\|null | Cancellation timestamp |
| `testmode` | bool | Test mode flag |

## Subscription Statuses

| Status | Description |
|--------|-------------|
| `created` | Subscription created, awaiting first payment |
| `trial` | In trial period |
| `active` | Active and billing normally |
| `canceled` | Canceled, will end at period end |
| `on_grace_period` | Canceled but still active until period end |
| `paused` | Temporarily paused |

## Helper Methods

```php
$subscription->isActive();      // true if actively billing
$subscription->isCanceled();    // true if canceled
$subscription->onTrial();       // true if in trial period
$subscription->onGracePeriod(); // true if canceled but still active
```
