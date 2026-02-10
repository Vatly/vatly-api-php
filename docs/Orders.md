# Orders

Orders represent completed transactions. An order is created when a checkout is successfully paid.

## Retrieve an Order

```php
$order = $vatly->orders->get('ord_abc123');

echo $order->id;
echo $order->status;
echo $order->total->forHumans();     // €35.09
echo $order->subtotal->forHumans();  // €29.00
```

## List Orders

```php
$orders = $vatly->orders->list();

foreach ($orders as $order) {
    echo $order->id . ': ' . $order->total->forHumans();
}
```

## Request Address Update

Request customer to update their billing address (useful for failed tax validations):

```php
$link = $vatly->orders->requestAddressUpdateLink('ord_abc123');

// Send link to customer
$updateUrl = $link->url;
```

## Order Refunds

```php
// Create a partial refund
$refund = $vatly->orders->refunds('ord_abc123')->create([
    'amount' => [
        'value' => '10.00',
        'currency' => 'EUR',
    ],
    'reason' => 'Customer requested partial refund',
]);

// Create a full refund
$refund = $vatly->orders->refunds('ord_abc123')->full([
    'reason' => 'Order canceled',
]);

// List refunds for an order
$refunds = $vatly->orders->refunds('ord_abc123')->list();
```

## Order Chargebacks

```php
// List chargebacks for an order
$chargebacks = $vatly->orders->chargebacks('ord_abc123')->list();

// Get specific chargeback
$chargeback = $vatly->orders->chargebacks('ord_abc123')->get('chb_xyz789');
```

## Order Object

| Property | Type | Description |
|----------|------|-------------|
| `id` | string | Unique identifier (`ord_...`) |
| `status` | string | `pending`, `paid`, `refunded`, `chargedback` |
| `customerId` | string | Customer ID |
| `checkoutId` | string | Source checkout ID |
| `subtotal` | Money | Amount before tax |
| `total` | Money | Total amount including tax |
| `taxes` | TaxCollection | Tax breakdown |
| `billingAddress` | Address | Customer billing address |
| `testmode` | bool | Test mode flag |
| `createdAt` | string | Creation timestamp |
| `paidAt` | string\|null | Payment timestamp |
