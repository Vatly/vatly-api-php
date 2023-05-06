<?php

namespace Vatly\API\Support\Types;

class WebhookUrls
{
    /**
    'webhookUrls' => [ // optional
        'paid' => 'https://your-website.com/webhooks/vatlify/order/123/paid',
        'canceled' => 'https://your-website.com/webhooks/vatlify/order/123/canceled',
        'refundCompleted' => 'https://your-website.com/webhooks/vatlify/order/123/refund-completed',
        'refundCanceled' => 'https://your-website.com/webhooks/vatlify/order/123/refund-canceled',
        'refundFailed' => 'https://your-website.com/webhooks/vatlify/order/123/refund-failed',
        'chargebackReceived' => 'https://your-website.com/webhooks/vatlify/order/123/chargeback-received',
        'chargebackReversed' => 'https://your-website.com/webhooks/vatlify/order/123/chargeback-reversed',
    ],
     */

    public ?string $paid;
    public ?string $canceled;
    public ?string $refundCompleted;
    public ?string $refundCanceled;
    public ?string $refundFailed;
    public ?string $chargebackReceived;
    public ?string $chargebackReversed;

    public static function createResourceFromApiResult($value): WebhookUrls
    {
        if (is_array($value)) {
            $value = (object) $value;
        }

        $object = new self();

        $object->paid = $value->paid ?? null;
        $object->canceled = $value->canceled ?? null;
        $object->refundCompleted = $value->refundCompleted ?? null;
        $object->refundCanceled = $value->refundCanceled ?? null;
        $object->refundFailed = $value->refundFailed ?? null;
        $object->chargebackReceived = $value->chargebackReceived ?? null;
        $object->chargebackReversed = $value->chargebackReversed ?? null;

        return $object;
    }
}
