<?php

namespace Vatly\API\Support\Types;

class CheckoutStatus
{
    /**
     * The checkout has just been created.
     */
    const STATUS_CREATED = "created";

    /**
     * The checkout has been paid.
     */
    const STATUS_PAID = "paid";

    /**
     * The checkout has been authorized.
     */
    const STATUS_AUTHORIZED = "authorized";

    /**
     * The checkout has been canceled.
     */
    const STATUS_CANCELED = "canceled";

    /**
     * The checkout is completed.
     */
    const STATUS_COMPLETED = "completed";

    /**
     * The checkout is expired.
     */
    const STATUS_EXPIRED = "expired";

    /**
     * The checkout is pending.
     */
    const STATUS_PENDING = "pending";
}
