<?php

namespace Vatly\API\Types;

class WebhookUrls
{
    /**
     * @example https://your-website.com/webhooks/vatlify/order/123/paid
     */
    public ?string $paid;

    /**
     * @example https://your-website.com/webhooks/vatlify/order/123/canceled
     */
    public ?string $canceled;

    /**
     * @example https://your-website.com/webhooks/vatlify/order/123/refund-completed
     */
    public ?string $refundCompleted;

    /**
     * @example https://your-website.com/webhooks/vatlify/order/123/refund-canceled
     */
    public ?string $refundCanceled;

    /**
     * @example https://your-website.com/webhooks/vatlify/order/123/refund-failed
     */
    public ?string $refundFailed;

    /**
     * @example https://your-website.com/webhooks/vatlify/order/123/chargeback-received
     */
    public ?string $chargebackReceived;

    /**
     * @example https://your-website.com/webhooks/vatlify/order/123/chargeback-reversed
     */
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
