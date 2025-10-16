<?php

namespace App\Services\Rules;

use App\Models\{Contract, RuleRun, RuleResult};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RuleEngine {
    public function __construct(private readonly string $rulesetPath) {}

    public function execute(Contract $contract): RuleRun {
        $latestExtraction = $contract->extractionRuns()->where('status','Succeeded')->latest()->firstOrFail();
        $fields = $latestExtraction->normalized_fields ?? [];

        $content = File::get($this->rulesetPath.'/rules.yaml');
        if (function_exists('yaml_parse')) {
            $yaml = yaml_parse($content);
        } else {
            // Fallback to symfony/yaml if ext-yaml is not installed
            $yaml = \Symfony\Component\Yaml\Yaml::parse($content);
        }
        $version = data_get($yaml,'version','0.0.0');
        $rules = data_get($yaml,'rules',[]);

        return DB::transaction(function() use ($contract,$version,$rules,$fields) {
            $run = RuleRun::create(['contract_id'=>$contract->id,'ruleset_version'=>$version,'status'=>'Started']);

            foreach ($rules as $r) {
                $key = $r['key'];
                $type = $r['type'];
                $params = $r['params'] ?? [];
                $onFail = $r['on_fail'] ?? [];

                $map = RuleRegistry::map();
                if (!isset($map[$type])) {
                    abort(500, "Unknown rule type: {$type}");
                }
                $class = $map[$type];

                /** @var RuleInterface $impl */
                $impl = app($class);
                $res = $impl->evaluate($fields, $params);

                $outcome = $res['outcome'];
                if ($outcome !== 'Passed' && $onFail) {
                    $outcome = $onFail['outcome'] ?? $outcome;
                    $res['risk_score'] = $onFail['risk_score'] ?? $res['risk_score'];
                    $res['message'] = $onFail['message'] ?? $res['message'];
                }

                RuleResult::create([
                    'rule_run_id' => $run->id,
                    'rule_key' => $key,
                    'outcome' => $outcome,
                    'risk_score' => $res['risk_score'] ?? null,
                    'inputs' => $res['inputs'] ?? null,
                    'evidence' => $res['evidence'] ?? null,
                    'message' => $res['message'] ?? null,
                ]);
            }

            $run->update(['status'=>'Completed']);

            $hasFail = $run->results()->where('outcome','Failed')->exists();
            $needsReview = $hasFail || $run->results()->where('outcome','NeedsReview')->exists();
            $contract->update([
                'status' => $needsReview ? 'NeedsReview' : 'Checked',
                'risk_level' => $needsReview ? 'Attention' : 'Low',
                'risk_summary' => [
                    'counts' => [
                        'passed' => $run->results()->where('outcome','Passed')->count(),
                        'needs_review' => $run->results()->where('outcome','NeedsReview')->count(),
                        'failed' => $run->results()->where('outcome','Failed')->count(),
                    ]
                ],
            ]);

            return $run;
        });
    }
}
