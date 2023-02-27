<?php

declare(strict_types=1);

namespace OpenAI\ValueObjects\Transporter;

use OpenAI\Enums\Transporter\ContentType;
use OpenAI\ValueObjects\ApiKey;

/**
 * @internal
 */
final class Headers {
    private array $headers = [];
    /**
     * Creates a new Headers value object.
     *
     * @param  array<string, string>  $headers
     */
    private function __construct(array $headers) {
        $this->headers = $headers;
    }

    /**
     * Creates a new Headers value object with the given API token.
     */
    public static function withAuthorization(ApiKey $apiKey): self {
        return new self([
            'Authorization' => "Bearer {$apiKey->toString()}",
        ]);
    }

    /**
     * Creates a new Headers value object, with the given content type, and the existing headers.
     */
    public function withContentType(string $contentType, string $suffix = ''): self {
        return new self([
            ...$this->headers,
            'Content-Type' => $contentType . $suffix,
        ]);
    }

    /**
     * Creates a new Headers value object, with the given organization, and the existing headers.
     */
    public function withOrganization(string $organization): self {
        return new self([
            ...$this->headers,
            'OpenAI-Organization' => $organization,
        ]);
    }

    /**
     * @return array<string, string> $headers
     */
    public function toArray(): array {
        return $this->headers;
    }
}
