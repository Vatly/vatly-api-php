# Chargebacks

Chargebacks occur when a customer disputes a charge with their bank or card issuer.

## Retrieve a Chargeback

```php
$chargeback = $vatly->chargebacks->get('chb_abc123');

echo $chargeback->id;
echo $chargeback->status;
echo $chargeback->amount->forHumans();
```

## List All Chargebacks

```php
$chargebacks = $vatly->chargebacks->list();

foreach ($chargebacks as $chargeback) {
    echo $chargeback->orderId . ': ' . $chargeback->amount->forHumans();
}
```

## Chargebacks for an Order

```php
$chargebacks = $vatly->orders->chargebacks('ord_abc123')->list();
```

## Chargeback Object

| Property | Type | Description |
|----------|------|-------------|
| `id` | string | Unique identifier (`chb_...`) |
| `orderId` | string | Related order ID |
| `status` | string | Current status |
| `amount` | Money | Disputed amount |
| `reason` | string\|null | Dispute reason |
| `testmode` | bool | Test mode flag |
| `createdAt` | string | Creation timestamp |

## Handling Chargebacks

Chargebacks are handled through the Vatly dashboard. When a chargeback occurs:

1. Vatly notifies you via webhook (`chargeback.created`)
2. Review the chargeback in your dashboard
3. Provide evidence if disputing
4. Vatly handles communication with payment provider

## Webhook Events

Subscribe to these webhook events to monitor chargebacks:

- `chargeback.created` - New chargeback filed
- `chargeback.updated` - Chargeback status changed
- `chargeback.won` - Dispute resolved in your favor
- `chargeback.lost` - Dispute resolved in customer's favor
