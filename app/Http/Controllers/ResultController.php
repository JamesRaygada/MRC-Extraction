<?php

namespace App\Http\Controllers;

use App\Models\RuleResult;
use Illuminate\Http\Request;
use App\Support\Audit;

class ResultController extends Controller {
    public function override(int $id, Request $request) {
        $result = RuleResult::findOrFail($id);
        $data = $request->validate([
            'outcome' => ['required','in:Passed,Failed,NeedsReview'],
            'reason' => ['required','string','max:1000'],
        ]);
        $result->update(['overridden'=>true,'override_reason'=>$data['reason'],'outcome'=>$data['outcome']]);
        Audit::log('result.override', $result, $data);
        return back()->with('toast','Result overridden.');
    }
}
