<?php

declare(strict_types=1);

namespace OpenAI\Responses\Files;

use OpenAI\Contracts\Response;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @implements Response<array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|null}>
 */
final class CreateResponse implements Response {
    public string $id;
    public string $object;
    public int $bytes;
    public int $createdAt;
    public string $filename;
    public string $purpose;
    public string $status;
    public array $statusDetails;

    /**
     * @use ArrayAccessible<array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|null}>
     */
    use ArrayAccessible;

    /**
     * @param  array<array-key, mixed> $statusDetails
     */
    private function __construct(
        string $id,
        string $object,
        int $bytes,
        int $createdAt,
        string $filename,
        string $purpose,
        string $status,
        array $statusDetails
    ) {
        $this->id = $id;
        $this->object = $object;
        $this->bytes = $bytes;
        $this->createdAt = $createdAt;
        $this->filename = $filename;
        $this->purpose = $purpose;
        $this->status = $status;
        $this->statusDetails = $statusDetails;
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|null}  $attributes
     */
    public static function from(array $attributes): self {
        return new self(
            $attributes['id'],
            $attributes['object'],
            $attributes['bytes'],
            $attributes['created_at'],
            $attributes['filename'],
            $attributes['purpose'],
            $attributes['status'],
            $attributes['status_details'] ?? [],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'object' => $this->object,
            'bytes' => $this->bytes,
            'created_at' => $this->createdAt,
            'filename' => $this->filename,
            'purpose' => $this->purpose,
            'status' => $this->status,
            'status_details' => $this->statusDetails,
        ];
    }
}
