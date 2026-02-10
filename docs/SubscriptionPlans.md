# Subscription Plans

Subscription plans define your recurring product offerings with pricing and billing intervals.

## Retrieve a Plan

```php
$plan = $vatly->subscriptionPlans->get('plan_abc123');

echo $plan->name;
echo $plan->basePrice->forHumans(); // €29.00
echo $plan->interval;               // month
```

## List Plans

```php
$plans = $vatly->subscriptionPlans->list();

foreach ($plans as $plan) {
    echo $plan->name . ': ' . $plan->basePrice->forHumans();
}
```

## Subscription Plan Object

| Property | Type | Description |
|----------|------|-------------|
| `id` | string | Unique identifier (`plan_...`) |
| `name` | string | Plan display name |
| `description` | string\|null | Plan description |
| `basePrice` | Money | Price per billing cycle |
| `interval` | string | `month` or `year` |
| `intervalCount` | int | Number of intervals per cycle |
| `trialDays` | int | Default trial period in days |
| `testmode` | bool | Test mode flag |
| `createdAt` | string | Creation timestamp |

## Using Plans in Checkouts

```php
$checkout = $vatly->checkouts->create([
    'products' => [
        [
            'id' => 'plan_abc123',
            'quantity' => 1,
            'trialDays' => 14,  // Override default trial
        ]
    ],
    'redirectUrlSuccess' => 'https://yourapp.com/success',
    'redirectUrlCanceled' => 'https://yourapp.com/canceled',
]);
```
