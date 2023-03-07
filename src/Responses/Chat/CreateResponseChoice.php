<?php

declare(strict_types=1);

namespace OpenAI\Responses\Chat;

final class CreateResponseChoice {
    public int $index;
    public CreateResponseMessage $message;
    public ?string $finishReason;

    private function __construct(
        int $index,
        CreateResponseMessage $message,
        ?string $finishReason
    ) {
        $this->index = $index;
        $this->message = $message;
        $this->finishReason = $finishReason;
    }

    /**
     * @param  array{index: int, message: array{role: string, content: string}, finish_reason: string|null}  $attributes
     */
    public static function from(array $attributes): self {
        return new self(
            $attributes['index'],
            CreateResponseMessage::from($attributes['message']),
            $attributes['finish_reason'],
        );
    }

    /**
     * @return array{index: int, message: array{role: string, content: string}, finish_reason: string|null}
     */
    public function toArray(): array {
        return [
            'index' => $this->index,
            'message' => $this->message->toArray(),
            'finish_reason' => $this->finishReason,
        ];
    }
}
