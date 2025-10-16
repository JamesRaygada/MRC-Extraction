<x-layout>
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">{{ $contract->title }}</h1>
    <form method="POST" action="{{ route('contracts.rerun',$contract->public_id) }}">@csrf<button class="btn">Re-run Extraction</button></form>
  </div>

  <x-card title="Status">
    <div>Status: <strong>{{ $contract->status }}</strong></div>
    @if($contract->risk_summary)
      <div class="text-sm text-gray-600 mt-2">Passed: {{ data_get($contract->risk_summary,'counts.passed',0) }} · Needs Review: {{ data_get($contract->risk_summary,'counts.needs_review',0) }} · Failed: {{ data_get($contract->risk_summary,'counts.failed',0) }}</div>
    @endif
  </x-card>

  <x-card title="Extracted Fields" class="mt-6">
    @if($latestExtraction)
      <pre class="text-sm">{{ json_encode($latestExtraction->normalized_fields, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) }}</pre>
    @else
      <div class="text-gray-500">No extraction yet.</div>
    @endif
  </x-card>

  <x-card title="Sanctions Checks" class="mt-6">
    @if($latestRuleRun)
      <table class="w-full text-sm">
        <tr class="text-gray-500"><th class="text-left p-2">Rule</th><th class="text-left p-2">Outcome</th><th class="text-left p-2">Risk</th><th class="p-2">Override</th></tr>
        @foreach($latestRuleRun->results as $r)
          <tr class="border-t">
            <td class="p-2">{{ $r->rule_key }}</td>
            <td class="p-2">{{ $r->outcome }}</td>
            <td class="p-2">{{ $r->risk_score ?? '—' }}</td>
            <td class="p-2">
              <form method="POST" action="{{ route('results.override',$r->id) }}" class="flex gap-2 items-center">
                @csrf
                <select name="outcome" class="input w-36">
                  <option {{ $r->outcome==='Passed'?'selected':'' }}>Passed</option>
                  <option {{ $r->outcome==='NeedsReview'?'selected':'' }}>NeedsReview</option>
                  <option {{ $r->outcome==='Failed'?'selected':'' }}>Failed</option>
                </select>
                <input name="reason" class="input w-64" placeholder="Reason" required>
                <button class="btn">Save</button>
              </form>
            </td>
          </tr>
        @endforeach
      </table>
    @else
      <div class="text-gray-500">No rule run yet.</div>
    @endif
  </x-card>
</x-layout>
