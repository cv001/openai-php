<?php

declare(strict_types=1);

namespace OpenAI\Responses\Moderations;

use OpenAI\Contracts\Response;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @implements Response<array{id: string, model: string, results: array<int, array{categories: array<string, bool>, category_scores: array<string, float>, flagged: bool}>}>
 */
final class CreateResponse implements Response {
    public string $id;
    public string $model;
    /**
     * @var array<int, CreateResponseResult>
     */
    public array $results;
    /**
     * @use ArrayAccessible<array{id: string, model: string, results: array<int, array{categories: array<string, bool>, category_scores: array<string, float>, flagged: bool}>}>
     */
    use ArrayAccessible;

    /**
     * @param  array<int, CreateResponseResult>  $results
     */
    private function __construct(
        string $id,
        string $model,
        array $results
    ) {
        $this->id = $id;
        $this->model = $model;
        $this->results = $results;
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{id: string, model: string, results: array<int, array{categories: array<string, bool>, category_scores: array<string, float>, flagged: bool}>}  $attributes
     */
    public static function from(array $attributes): self {
        $results = array_map(fn (array $result): CreateResponseResult => CreateResponseResult::from(
            $result
        ), $attributes['results']);

        return new self(
            $attributes['id'],
            $attributes['model'],
            $results,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'results' => array_map(
                static fn (CreateResponseResult $result): array => $result->toArray(),
                $this->results,
            ),
        ];
    }
}
