<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleResult extends Model {
    use HasFactory;
    protected $fillable = ['rule_run_id','rule_key','outcome','risk_score','inputs','evidence','message','overridden','override_reason'];
    protected $casts = [ 'inputs'=>'array','evidence'=>'array' ];
    public function ruleRun(){ return $this->belongsTo(RuleRun::class); }
}
