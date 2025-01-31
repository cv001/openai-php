<?php

declare(strict_types=1);

namespace OpenAI\Responses\Chat;

final class CreateResponseMessage {
    public string $role;
    public string $content;
    private function __construct(
        string $role,
        string $content
    ) {
        $this->role = $role;
        $this->content = $content;
    }

    /**
     * @param  array{role: string, content: string}  $attributes
     */
    public static function from(array $attributes): self {
        return new self(
            $attributes['role'],
            $attributes['content'],
        );
    }

    /**
     * @return array{role: string, content: string}
     */
    public function toArray(): array {
        return [
            'role' => $this->role,
            'content' => $this->content,
        ];
    }
}
