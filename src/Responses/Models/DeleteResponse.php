<?php

declare(strict_types=1);

namespace OpenAI\Responses\Models;

use OpenAI\Contracts\Response;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @implements Response<array{id: string, object: string, deleted: bool}>
 */
final class DeleteResponse implements Response {
    public string $id;
    public string $object;
    public bool $deleted;
    /**
     * @use ArrayAccessible<array{id: string, object: string, deleted: bool}>
     */
    use ArrayAccessible;

    private function __construct(
        string $id,
        string $object,
        bool $deleted
    ) {
        $this->id = $id;
        $this->object = $object;
        $this->deleted = $deleted;
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{id: string, object: string, deleted: bool}  $attributes
     */
    public static function from(array $attributes): self {
        return new self(
            $attributes['id'],
            $attributes['object'],
            $attributes['deleted'],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'object' => $this->object,
            'deleted' => $this->deleted,
        ];
    }
}
