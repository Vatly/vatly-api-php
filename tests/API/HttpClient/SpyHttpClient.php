<?php

declare(strict_types=1);

namespace Vatly\Tests\API\HttpClient;

use Vatly\API\HttpClient\HttpClientInterface;

class SpyHttpClient implements HttpClientInterface
{
    protected ?object $sendReturn;
    protected array $recordedSends = [];

    public function send(
        string $httpMethod,
        string $url,
        array $headers,
        string $httpBody
    ): ?object {
        $this->recordSend($httpMethod, $url, $headers, $httpBody);

        return $this->sendReturn;
    }

    public function versionString(): string
    {
        return 'SpyHttpClient/007';
    }

    public function setSendReturnObject(object $value): self
    {
        $this->sendReturn = $value;

        return $this;
    }

    public function wasSent(
        string $httpMethod,
        string $url,
        array $headers,
        string $httpBody
    ): bool {
        return count(array_filter($this->recordedSends, function ($item) use ($httpMethod, $url, $headers, $httpBody) {
            return $item['httpMethod'] === $httpMethod
                && $item['url'] === $url
                && $item['headers'] === $headers
                && $item['httpBody'] === $httpBody;
        })) > 0;
    }

    public function recordedSends(): array
    {
        return $this->recordedSends();
    }

    private function recordSend($httpMethod, $url, $headers, $httpBody): void
    {
        $this->recordedSends[] = [
            'time' => time(),
            'httpMethod' => $httpMethod,
            'url' => $url,
            '$headers' => $headers,
            '$httpBody' => $httpBody,
        ];
    }

    public function supportsDebugging(): bool
    {
        return false;
    }

    public function enableDebugging(): void
    {
        //
    }

    public function disableDebugging(): void
    {
        //
    }
}
