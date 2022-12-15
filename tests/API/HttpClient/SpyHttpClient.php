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
        $sanitizedHttpBody = preg_replace('/\s+/', ' ', trim($httpBody));
        $sanitizedHttpBody = str_replace(', "', ',"', $sanitizedHttpBody);

        return count(array_filter($this->recordedSends, function ($item) use ($httpMethod, $url, $headers, $sanitizedHttpBody) {
            return $item['httpMethod'] === $httpMethod
                && $item['url'] === $url
                && $item['headers'] === $headers
                && $item['httpBody'] === $sanitizedHttpBody;
        })) > 0;
    }

    /**
     * Whether the provided call was the only call that was made, and made only once.
     *
     * @param string $httpMethod
     * @param string $url
     * @param array $headers
     * @param string $httpBody
     * @return bool
     */
    public function wasSentOnly(
        string $httpMethod,
        string $url,
        array $headers,
        string $httpBody
    ): bool {
        if ($this->countRecordedSends() !== 1) {
            return false;
        }

        return $this->wasSent(
            $httpMethod,
            $url,
            $headers,
            $httpBody,
        );
    }

    public function countRecordedSends(): int
    {
        return count($this->recordedSends);
    }

    public function recordedSends(): array
    {
        return $this->recordedSends;
    }

    private function recordSend(
        string $httpMethod,
        string $url,
        array $headers,
        ?string $httpBody
    ): void {
        $sanitizedHeaders = array_filter($headers, function ($key) {
            return ! in_array($key, [
                'Accept',
                'Authorization',
                'User-Agent',
                'Content-Type',
                'X-Vatly-Client-Info',
            ]);
        }, ARRAY_FILTER_USE_KEY);

        $this->recordedSends[] = [
            'time' => time(),
            'httpMethod' => $httpMethod,
            'url' => $url,
            'headers' => $sanitizedHeaders,
            'httpBody' => $httpBody,
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
