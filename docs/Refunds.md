# Refunds

Refunds return money to customers for completed orders.

## Retrieve a Refund

```php
$refund = $vatly->refunds->get('ref_abc123');

echo $refund->id;
echo $refund->status;
echo $refund->amount->forHumans();
```

## List All Refunds

```php
$refunds = $vatly->refunds->list();

foreach ($refunds as $refund) {
    echo $refund->id . ': ' . $refund->amount->forHumans();
}
```

## Create a Refund (via Order)

```php
// Partial refund
$refund = $vatly->orders->refunds('ord_abc123')->create([
    'amount' => [
        'value' => '15.00',
        'currency' => 'EUR',
    ],
    'reason' => 'Partial refund for unused service',
]);

// Full refund
$refund = $vatly->orders->refunds('ord_abc123')->full([
    'reason' => 'Customer requested cancellation',
]);
```

## Refund Object

| Property | Type | Description |
|----------|------|-------------|
| `id` | string | Unique identifier (`ref_...`) |
| `orderId` | string | Related order ID |
| `status` | string | `pending`, `processing`, `completed`, `failed` |
| `amount` | Money | Refund amount |
| `reason` | string\|null | Refund reason |
| `testmode` | bool | Test mode flag |
| `createdAt` | string | Creation timestamp |
| `completedAt` | string\|null | Completion timestamp |

## Refund Statuses

| Status | Description |
|--------|-------------|
| `pending` | Refund initiated, awaiting processing |
| `processing` | Refund is being processed |
| `completed` | Refund successful, funds returned |
| `failed` | Refund failed |
