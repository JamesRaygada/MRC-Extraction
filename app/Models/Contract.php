<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model {
    use HasFactory;
    protected $fillable = ['public_id','title','uploader_email','status','risk_level','risk_summary'];
    protected $casts = [ 'risk_summary' => 'array' ];

    public function files(){ return $this->hasMany(ContractFile::class); }
    public function extractionRuns(){ return $this->hasMany(ExtractionRun::class); }
    public function ruleRuns(){ return $this->hasMany(RuleRun::class); }
    public function reviewComments(){ return $this->hasMany(ReviewComment::class); }
}
