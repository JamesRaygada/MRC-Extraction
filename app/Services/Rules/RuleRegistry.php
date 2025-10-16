<?php

namespace App\Services\Rules;

class RuleRegistry {
    /** @return array<string, class-string<RuleInterface>> */
    public static function map(): array {
        return [
            'yaml-list-contains' => YamlListContainsRule::class,
            'numeric-threshold' => NumericThresholdRule::class,
        ];
    }
}
