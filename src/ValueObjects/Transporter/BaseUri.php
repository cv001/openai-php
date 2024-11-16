<?php

declare(strict_types=1);

namespace OpenAI\ValueObjects\Transporter;

use OpenAI\Contracts\Stringable;

/**
 * @internal
 */
final class BaseUri implements Stringable {
    private string $baseUri;
    /**
     * Creates a new Base URI value object.
     */
    private function __construct(string $baseUri) {
        $this->baseUri = $baseUri;
    }

    /**
     * Creates a new Base URI value object.
     */
    public static function from(string $baseUri): self {
        return new self($baseUri);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string {
        foreach (['http://', 'https://'] as $protocol) {
            if (str_starts_with($this->baseUri, $protocol)) {
                return "{$this->baseUri}/";
            }
        }
        return "https://{$this->baseUri}/";
    }
}
