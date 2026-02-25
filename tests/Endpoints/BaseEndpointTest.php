<?php

declare(strict_types=1);

namespace Vatly\Tests\Endpoints;

use Vatly\Tests\BaseTestCase;

abstract class BaseEndpointTest extends BaseTestCase
{
    public const API_ENDPOINT_URL = 'https://api.vatly.com/v1';
    public const WEBSITE_ENDPOINT_URL = 'https://vatly.com/';
}
