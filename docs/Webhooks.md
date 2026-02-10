# Webhooks

Webhooks notify your application of events in real-time. Configure webhook endpoints in the [Vatly Dashboard](https://my.vatly.com).

## Verifying Webhook Signatures

All webhooks include a signature for verification:

```php
use Vatly\Api\Webhooks\WebhookSignatureValidator;

$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_VATLY_SIGNATURE'] ?? '';
$secret = 'your_webhook_secret'; // From dashboard

$validator = new WebhookSignatureValidator($secret);

if (!$validator->isValid($payload, $signature)) {
    http_response_code(401);
    exit('Invalid signature');
}

// Process the webhook
$event = json_decode($payload, true);
```

## Webhook Payload Structure

```json
{
    "id": "evt_abc123",
    "type": "checkout.paid",
    "createdAt": "2024-01-15T10:30:00Z",
    "testmode": false,
    "data": {
        "id": "chk_xyz789",
        "status": "paid",
        "orderId": "ord_def456"
    }
}
```

## Available Events

### Checkout Events

| Event | Description |
|-------|-------------|
| `checkout.created` | Checkout session created |
| `checkout.paid` | Checkout completed successfully |
| `checkout.canceled` | Customer canceled checkout |
| `checkout.expired` | Checkout expired |
| `checkout.failed` | Payment failed |

### Subscription Events

| Event | Description |
|-------|-------------|
| `subscription.created` | New subscription started |
| `subscription.renewed` | Subscription renewed |
| `subscription.canceled` | Subscription canceled |
| `subscription.updated` | Subscription modified |
| `subscription.trial_ended` | Trial period ended |

### Order Events

| Event | Description |
|-------|-------------|
| `order.created` | New order created |
| `order.paid` | Order payment confirmed |
| `order.refunded` | Order refunded (partial or full) |

### Refund Events

| Event | Description |
|-------|-------------|
| `refund.created` | Refund initiated |
| `refund.completed` | Refund processed successfully |
| `refund.failed` | Refund failed |

### Chargeback Events

| Event | Description |
|-------|-------------|
| `chargeback.created` | Chargeback filed |
| `chargeback.updated` | Chargeback status changed |
| `chargeback.won` | Dispute won |
| `chargeback.lost` | Dispute lost |

## Example Webhook Handler

```php
use Vatly\Api\Webhooks\WebhookSignatureValidator;

$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_VATLY_SIGNATURE'] ?? '';

$validator = new WebhookSignatureValidator(env('VATLY_WEBHOOK_SECRET'));

if (!$validator->isValid($payload, $signature)) {
    return response('Invalid signature', 401);
}

$event = json_decode($payload, true);

switch ($event['type']) {
    case 'checkout.paid':
        $checkout = $event['data'];
        // Provision access, send confirmation email
        break;

    case 'subscription.renewed':
        $subscription = $event['data'];
        // Update subscription records
        break;

    case 'subscription.canceled':
        $subscription = $event['data'];
        // Handle cancellation, send retention email
        break;

    case 'chargeback.created':
        $chargeback = $event['data'];
        // Alert team, gather evidence
        break;
}

return response('OK', 200);
```

## Best Practices

1. **Always verify signatures** - Never trust unverified webhooks
2. **Respond quickly** - Return 200 within 30 seconds
3. **Handle idempotency** - Webhooks may be retried; use event ID to deduplicate
4. **Log everything** - Store raw payloads for debugging
5. **Use queues** - Process webhooks asynchronously for heavy operations
