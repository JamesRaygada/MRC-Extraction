<?php

namespace App\Services\Rules;

class NumericThresholdRule implements RuleInterface {
    public function evaluate(array $fields, array $params): array {
        $value = (float) (data_get($fields, $params['field'] ?? null) ?? 0);
        $max = (float) ($params['max'] ?? INF);
        $ok = $value <= $max;
        return [
            'outcome' => $ok ? 'Passed' : 'NeedsReview',
            'risk_score' => $ok ? null : 'Medium',
            'message' => $ok ? null : "Value {$value} exceeds threshold {$max}",
            'inputs' => ['value' => $value,'max' => $max],
            'evidence' => [],
        ];
    }
}
