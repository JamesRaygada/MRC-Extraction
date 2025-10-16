<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleRun extends Model {
    use HasFactory;
    protected $fillable = ['contract_id','ruleset_version','status'];
    public function results(){ return $this->hasMany(RuleResult::class); }
    public function contract(){ return $this->belongsTo(Contract::class); }
}
