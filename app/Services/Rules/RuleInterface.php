<?php

namespace App\Services\Rules;

interface RuleInterface {
    /** @param array $fields normalized extraction fields */
    public function evaluate(array $fields, array $params): array;
}
