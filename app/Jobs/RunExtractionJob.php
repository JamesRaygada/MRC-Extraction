<?php

namespace App\Jobs;

use App\Models\{Contract, ExtractionRun};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunExtractionJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct(public int $contractId) {}

    public function handle(\App\Services\AI\AIProviderInterface $ai): void {
        $contract = Contract::findOrFail($this->contractId);
        $run = ExtractionRun::create([
            'contract_id'=>$contract->id,
            'engine'=>'unknown','engine_version'=>null,'status'=>'Started'
        ]);
        try {
            $res = $ai->extract($contract);
            $run->update([
                'engine'=>$res['engine'],
                'engine_version'=>$res['engine_version'],
                'status'=>'Succeeded',
                'raw_output'=>$res['raw'],
                'normalized_fields'=>$res['normalized'],
            ]);
            $contract->update(['status'=>'Extracted']);
            RunSanctionsJob::dispatch($contract->id)->onQueue('rules');
        } catch (\Throwable $e) {
            $run->update(['status'=>'Failed','error_message'=>$e->getMessage()]);
            $contract->update(['status'=>'ExtractionFailed']);
        }
    }
}
