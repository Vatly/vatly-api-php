<?php

namespace Vatly\API\Resources;

use Vatly\API\Resources\Links\OrderLinks;
use Vatly\API\Types\Address;
use Vatly\API\Types\Money;
use Vatly\API\Types\OrderStatus;

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

    /**
     * @example customer_78b146a7de7d417e9d68d7e6ef193d18
     */
    public string $customerId;

    /**
     * @example 2020-01-01
     */
    public string $orderedAt;

    public bool $testmode;

    public Money $total;

    public Money $taxAmount;

    public Money $subtotal;

    /**
     * @example VAT
     */
    public string $taxName;

    /**
     * @example 21.00
     */
    public string $taxPercentage;

    /**
     * @example creditcard
     */
    public string $paymentMethod;

    public ?string $invoiceNumber = null;

    /** @see OrderStatus */
    public string $status;

    public bool $cancelled = false;

    public OrderLinks $_links;

    public Address $customerDetails;

    public Address $merchantDetails;

    /**
     * @var OrderLine[]|array
     */
    public array $lines;


    /**
     * Get the line value objects
     *
     * @return OrderLineCollection
     */
    public function lines(): OrderLineCollection
    {
        return ResourceFactory::createCursorResourcePage(
            $this->apiClient,
            $this->lines,
            OrderLine::class,
            null,
            OrderLineCollection::class,
        );
    }

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
