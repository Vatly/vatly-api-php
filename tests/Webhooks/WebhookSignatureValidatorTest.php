<?php

declare(strict_types=1);

namespace Vatly\Tests\Webhooks;

use PHPUnit\Framework\TestCase;
use Vatly\API\Exceptions\InvalidSignatureException;
use Vatly\API\Webhooks\WebhookSignatureValidator;

class WebhookSignatureValidatorTest extends TestCase
{
    private string $webhookSecret = 'test_webhook_secret_key';

    public function test_it_validates_a_correct_signature(): void
    {
        $validator = new WebhookSignatureValidator($this->webhookSecret);
        $payload = '{"event":"order.paid","data":{"id":"ord_123"}}';
        $signature = hash_hmac('sha256', $payload, $this->webhookSecret);

        // Should not throw
        $validator->verify($payload, $signature);

        $this->assertTrue($validator->isValid($payload, $signature));
    }

    public function test_it_throws_exception_for_invalid_signature(): void
    {
        $validator = new WebhookSignatureValidator($this->webhookSecret);
        $payload = '{"event":"order.paid","data":{"id":"ord_123"}}';
        $invalidSignature = 'invalid_signature';

        $this->expectException(InvalidSignatureException::class);
        $this->expectExceptionMessage('Invalid webhook signature');

        $validator->verify($payload, $invalidSignature);
    }

    public function test_is_valid_returns_false_for_invalid_signature(): void
    {
        $validator = new WebhookSignatureValidator($this->webhookSecret);
        $payload = '{"event":"order.paid","data":{"id":"ord_123"}}';
        $invalidSignature = 'invalid_signature';

        $this->assertFalse($validator->isValid($payload, $invalidSignature));
    }

    public function test_it_rejects_tampered_payload(): void
    {
        $validator = new WebhookSignatureValidator($this->webhookSecret);
        $originalPayload = '{"event":"order.paid","data":{"id":"ord_123"}}';
        $tamperedPayload = '{"event":"order.paid","data":{"id":"ord_456"}}';
        $signature = hash_hmac('sha256', $originalPayload, $this->webhookSecret);

        $this->assertFalse($validator->isValid($tamperedPayload, $signature));
    }

    public function test_it_rejects_signature_with_wrong_secret(): void
    {
        $validator = new WebhookSignatureValidator($this->webhookSecret);
        $payload = '{"event":"order.paid","data":{"id":"ord_123"}}';
        $signatureWithWrongSecret = hash_hmac('sha256', $payload, 'wrong_secret');

        $this->assertFalse($validator->isValid($payload, $signatureWithWrongSecret));
    }

    public function test_calculate_signature_returns_correct_hmac(): void
    {
        $validator = new WebhookSignatureValidator($this->webhookSecret);
        $payload = '{"event":"order.paid","data":{"id":"ord_123"}}';

        $expectedSignature = hash_hmac('sha256', $payload, $this->webhookSecret);

        $this->assertSame($expectedSignature, $validator->calculateSignature($payload));
    }
}
