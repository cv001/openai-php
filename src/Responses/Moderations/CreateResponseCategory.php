<?php

declare(strict_types=1);

namespace OpenAI\Responses\Moderations;

final class CreateResponseCategory {
    public string $category;
    public bool $violated;
    public float $score;

    private function __construct(
        string $category,
        bool $violated,
        float $score
    ) {
        $this->category = $category;
        $this->violated = $violated;
        $this->score = $score;
    }

    /**
     * @param  array{category: string, violated: bool, score: float}  $attributes
     */
    public static function from(array $attributes): self {
        return new self(
            $attributes['category'],
            $attributes['violated'],
            $attributes['score'],
        );
    }
}
