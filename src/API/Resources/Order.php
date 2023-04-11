<?php

namespace Vatly\API\Resources;

use Vatly\API\Resources\Links\OrderLinks;

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
     * @example profile_bb0297e0309a4908a2eff8ee4d62a23f
     */
    public string $profileId;

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

    public int $total;

    public int $tax;

    public int $subtotal;

    public string $currency;

    public string $vat;
    public string $paymentMethod;

    public ?string $invoiceNumber = null;

    public bool $paid = false;

    public bool $cancelled = false;

    public OrderLinks $_links;

    public Address $customerDetails;

    public Address $sellerDetails;
}
