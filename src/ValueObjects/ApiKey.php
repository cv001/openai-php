<?php

declare(strict_types=1);

namespace OpenAI\ValueObjects;

use OpenAI\Contracts\Stringable;

/**
 * @internal
 */
final class ApiKey implements Stringable {
    public string $apiKey;

    /**
     * Creates a new API token value object.
     */
    private function __construct(string $apiKey) {
        $this->apiKey = $apiKey;
    }

    public static function from(string $apiKey): self {
        return new self($apiKey);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string {
        return $this->apiKey;
    }
}
