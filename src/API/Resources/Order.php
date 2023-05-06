<?php

namespace Vatly\API\Resources;

use Vatly\API\Resources\Links\OrderLinks;
use Vatly\API\Support\Types\Address;
use Vatly\API\Support\Types\CurrencyAmount;
use Vatly\API\Support\Types\OrderStatus;

class Order extends BaseResource
{
    /**
     * @example order_66fc8a40718b46bea50f1a25f456d243
     */
    public string $id;

    /**
     * @example order
     */
    public string $resource;

    /**
     * @example merchant_f7f3cbf96f6c444abd76aafaf99ecde9
     */
    public string $merchantId;

    public string $customerId;

    /**
     * @example 2020-01-01
     */
    public string $orderedAt;

    public bool $testmode;

    public CurrencyAmount $total;

    public CurrencyAmount $taxAmount;

    public CurrencyAmount $subtotal;

    public string $taxName;
    public string $taxPercentage;

    public string $paymentMethod;

    public ?string $invoiceNumber = null;

    /** @see OrderStatus */
    public string $status;

    public bool $cancelled = false;

    public OrderLinks $_links;

    public Address $customerDetails;

    public Address $merchantDetails;

    /**
     * Is this order created?
     */
    public function isCreated(): bool
    {
        return $this->status === OrderStatus::STATUS_CREATED;
    }

    /**
     * Is this order paid for?
     */
    public function isPaid(): bool
    {
        return $this->status === OrderStatus::STATUS_PAID;
    }

    /**
     * Is this order authorized?
     */
    public function isAuthorized(): bool
    {
        return $this->status === OrderStatus::STATUS_AUTHORIZED;
    }

    /**
     * Is this order canceled?
     */
    public function isCanceled(): bool
    {
        return $this->status === OrderStatus::STATUS_CANCELED;
    }

    /**
     * Is this order completed?
     */
    public function isCompleted(): bool
    {
        return $this->status === OrderStatus::STATUS_COMPLETED;
    }

    /**
     * Is this order expired?
     */
    public function isExpired(): bool
    {
        return $this->status === OrderStatus::STATUS_EXPIRED;
    }

    /**
     * Is this order completed?
     */
    public function isPending(): bool
    {
        return $this->status === OrderStatus::STATUS_PENDING;
    }

}
