<?php

declare(strict_types=1);

namespace OpenAI\Responses\Completions;

final class CreateResponseChoice {
    public string $text;
    public int $index;
    public ?CreateResponseChoiceLogprobs $logprobs;
    public ?string $finishReason;

    private function __construct(
        string $text,
        int $index,
        ?CreateResponseChoiceLogprobs $logprobs,
        ?string $finishReason
    ) {
        $this->text = $text;
        $this->index = $index;
        $this->logprobs = $logprobs;
        $this->finishReason = $finishReason;
    }

    /**
     * @param  array{text: string, index: int, logprobs: array{tokens: array<int, string>, token_logprobs: array<int, float>, top_logprobs: array<int, string>|null, text_offset: array<int, int>}|null, finish_reason: ?string}  $attributes
     */
    public static function from(array $attributes): self {
        return new self(
            $attributes['text'],
            $attributes['index'],
            $attributes['logprobs'] ? CreateResponseChoiceLogprobs::from($attributes['logprobs']) : null,
            $attributes['finish_reason'],
        );
    }

    /**
     * @return array{text: string, index: int, logprobs: array{tokens: array<int, string>, token_logprobs: array<int, float>, top_logprobs: array<int, string>|null, text_offset: array<int, int>}|null, finish_reason: ?string}
     */
    public function toArray(): array {
        return [
            'text' => $this->text,
            'index' => $this->index,
            'logprobs' => $this->logprobs instanceof \OpenAI\Responses\Completions\CreateResponseChoiceLogprobs ? $this->logprobs->toArray() : null,
            'finish_reason' => $this->finishReason,
        ];
    }
}
