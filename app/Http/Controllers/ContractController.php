<?php

namespace App\Http\Controllers;

use App\Models\{Contract, ContractFile};
use App\Jobs\RunExtractionJob;
use App\Http\Requests\UploadContractRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContractController extends Controller {
    public function index() {
        $contracts = Contract::latest()->paginate(20);
        return view('contracts.index', compact('contracts'));
    }

    public function show(string $publicId) {
        $contract = Contract::where('public_id',$publicId)->firstOrFail();
        $latestExtraction = $contract->extractionRuns()->latest()->first();
        $latestRuleRun = $contract->ruleRuns()->latest()->with('results')->first();
        return view('contracts.show', compact('contract','latestExtraction','latestRuleRun'));
    }

    public function store(UploadContractRequest $request) {
        $data = $request->validated();
        $contract = Contract::create([
            'public_id' => (string) Str::uuid(),
            'title' => $data['title'],
            'uploader_email' => $data['uploader_email'] ?? null,
        ]);

        foreach (['primary','spreadsheets'] as $bucket) {
            $files = $bucket === 'primary' ? [$data['primary']] : ($data['spreadsheets'] ?? []);
            foreach ($files as $file) {
                $path = $file->store("contracts/{$contract->public_id}", config('filesystems.default'));
                $absolute = Storage::disk(config('filesystems.default'))->path($path);

                $clamOk = app(\App\Services\FileScanner\ClamAvScanner::class)->scan($absolute);
                if (!$clamOk) { throw new \RuntimeException('Virus scan failed'); }

                ContractFile::create([
                    'contract_id'=>$contract->id,
                    'kind' => $bucket == 'primary' ? 'primary' : 'spreadsheet',
                    'original_name'=>$file->getClientOriginalName(),
                    'mime'=>$file->getClientMimeType(),
                    'size_bytes'=>$file->getSize(),
                    'disk'=>config('filesystems.default'),
                    'path'=>$path,
                    'sha256'=>hash_file('sha256', $absolute),
                    'clamav_passed'=>true,
                ]);
            }
        }

        RunExtractionJob::dispatch($contract->id)->onQueue('extraction');
        return redirect()->route('contracts.show', $contract->public_id)
            ->with('toast','Upload received. Extraction queued.');
    }

    public function rerun(string $publicId) {
        $contract = Contract::where('public_id',$publicId)->firstOrFail();
        RunExtractionJob::dispatch($contract->id)->onQueue('extraction');
        return back()->with('toast','Re-run dispatched.');
    }
}
