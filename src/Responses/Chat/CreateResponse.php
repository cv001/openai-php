<?php

declare(strict_types=1);

namespace OpenAI\Responses\Chat;

use OpenAI\Contracts\Response;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @implements Response<array{id: string, object: string, created: int, model: string, choices: array<int, array{index: int, message: array{role: string, content: string}, finish_reason: string|null}>, usage: array{prompt_tokens: int, completion_tokens: int|null, total_tokens: int}}>
 */
final class CreateResponse implements Response {
    public string $id;
    public string $object;
    public int $created;
    public string $model;

    /**
     * @var array<int, CreateResponseChoice>
     */
    public array $choices;
    public CreateResponseUsage $usage;

    /**
     * @use ArrayAccessible<array{id: string, object: string, created: int, model: string, choices: array<int, array{index: int, message: array{role: string, content: string}, finish_reason: string|null}>, usage: array{prompt_tokens: int, completion_tokens: int|null, total_tokens: int}}>
     */
    use ArrayAccessible;

    /**
     * @param array<int, CreateResponseChoice> $choices
     */
    private function __construct(
        string $id,
        string $object,
        int $created,
        string $model,
        array $choices,
        CreateResponseUsage $usage
    ) {
        $this->id = $id;
        $this->object = $object;
        $this->created = $created;
        $this->model = $model;
        $this->choices = $choices;
        $this->usage = $usage;
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param array{id: string, object: string, created: int, model: string, choices: array<int, array{index: int, message: array{role: string, content: string}, finish_reason: string|null}>, usage: array{prompt_tokens: int, completion_tokens: int|null, total_tokens: int}} $attributes
     */
    public static function from(array $attributes): self {
        $choices = array_map(fn (array $result): CreateResponseChoice => CreateResponseChoice::from(
            $result
        ), $attributes['choices']);

        return new self(
            $attributes['id'],
            $attributes['object'],
            $attributes['created'],
            $attributes['model'],
            $choices,
            CreateResponseUsage::from($attributes['usage'])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'object' => $this->object,
            'created' => $this->created,
            'model' => $this->model,
            'choices' => array_map(
                static fn (CreateResponseChoice $result): array => $result->toArray(),
                $this->choices,
            ),
            'usage' => $this->usage->toArray(),
        ];
    }
}