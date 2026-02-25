<?php

namespace Vatly\API\Types;

class ProductStatus
{
    /**
     * The product/plan is approved and available for use.
     */
    public const APPROVED = "approved";

    /**
     * The product/plan is in draft and not yet available.
     */
    public const DRAFT = "draft";

    /**
     * The product/plan has been archived.
     */
    public const ARCHIVED = "archived";
}
