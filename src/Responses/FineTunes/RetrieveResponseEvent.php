<?php

declare(strict_types=1);

namespace OpenAI\Responses\FineTunes;

use OpenAI\Contracts\Response;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @implements Response<array{object: string, created_at: int, level: string, message: string}>
 */
final class RetrieveResponseEvent implements Response {
    public string $object;
    public int $createdAt;
    public string $level;
    public string $message;

    /**
     * @use ArrayAccessible<array{object: string, created_at: int, level: string, message: string}>
     */
    use ArrayAccessible;

    private function __construct(
        string $object,
        int $createdAt,
        string $level,
        string $message
    ) {
        $this->object = $object;
        $this->createdAt = $createdAt;
        $this->level = $level;
        $this->message = $message;
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{object: string, created_at: int, level: string, message: string}  $attributes
     */
    public static function from(array $attributes): self {
        return new self(
            $attributes['object'],
            $attributes['created_at'],
            $attributes['level'],
            $attributes['message'],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array {
        return [
            'object' => $this->object,
            'created_at' => $this->createdAt,
            'level' => $this->level,
            'message' => $this->message,
        ];
    }
}
