<?php

declare(strict_types=1);

namespace OpenAI\Enums\Moderations;

final class Category {
    public const Hate = 'hate';
    public const HateThreatening = 'hate/threatening';
    public const SelfHarm = 'self-harm';
    public const Sexual = 'sexual';
    public const SexualMinors = 'sexual/minors';
    public const Violence = 'violence';
    public const ViolenceGraphic = 'violence/graphic';

    /**
     * @return array<string>
     */
    public static function cases(): array {
        return [
            self::Hate,
            self::HateThreatening,
            self::SelfHarm,
            self::Sexual,
            self::SexualMinors,
            self::Violence,
            self::ViolenceGraphic,
        ];
    }
}
