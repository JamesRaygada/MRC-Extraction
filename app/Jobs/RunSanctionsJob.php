<?php

namespace App\Jobs;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunSanctionsJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct(public int $contractId) {}

    public function handle(): void {
        $contract = Contract::findOrFail($this->contractId);
        $engine = new \App\Services\Rules\RuleEngine(base_path('rulesets/v1'));
        $engine->execute($contract);
    }
}
