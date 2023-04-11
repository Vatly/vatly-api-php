<?php

declare(strict_types=1);

namespace Vatly\API\Resources;

use Vatly\API\Resources\Links\CheckoutLinks;

class Checkout extends BaseResource
{
    /**
     * @example checkout_ec853f457eee4276b9ecb2c7558fe557
     */
    public string $id;

    /**
     * @example checkout
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
    public string $orderId;

    public bool $testmode;

    /**
     * @example https://example.com/checkout/success
     */
    public string $redirectUrlSuccess;

    /**
     * @example https://example.com/checkout/failure
     */
    public string $redirectUrlCanceled;

    /**
     * @var array|object|null
     * @example ["order_id" => "123456"]
     */
    public $metadata = null;

    public CheckoutLinks $_links;

    public ?int $total = null;

    public ?int $tax = null;

    public ?int $subtotal = null;

    public ?string $currency = null;

    public ?string $vat = null;
    public ?string $paymentMethod = null;

    public bool $paid = false;
}
