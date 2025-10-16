<?php

namespace App\Services\Rules;

class YamlListContainsRule implements RuleInterface {
    public function evaluate(array $fields, array $params): array {
        $field = data_get($fields, $params['field'] ?? null);
        $deny = $params['denylist'] ?? [];
        $ok = $field !== null && !in_array($field, $deny, true);
        return [
            'outcome' => $ok ? 'Passed' : 'NeedsReview',
            'risk_score' => $ok ? null : 'High',
            'message' => $ok ? null : 'Value present in denylist',
            'inputs' => ['value' => $field, 'denylist' => $deny],
            'evidence' => [],
        ];
    }
}
