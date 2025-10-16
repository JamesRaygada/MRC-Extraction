<?php

namespace App\Services\AI;

use App\Models\Contract;

class OpenAIProvider implements AIProviderInterface {
    public function __construct(private readonly ?string $model = null) {}

    public function extract(Contract $contract): array {
        // Stub implementation. Replace with real provider call.
        $normalized = [
            'counterparty_name' => 'ACME Ltd',
            'jurisdiction' => 'GB',
            'effective_date' => '2024-01-15',
            'amount' => 250000.00,
        ];
        return [
            'engine' => 'openai',
            'engine_version' => $this->model ?? 'gpt-x-stub',
            'raw' => ['note' => 'stubbed response'],
            'normalized' => $normalized,
        ];
    }
}
