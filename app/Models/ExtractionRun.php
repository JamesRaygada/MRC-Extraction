<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtractionRun extends Model {
    use HasFactory;
    protected $fillable = ['contract_id','engine','engine_version','status','raw_output','normalized_fields','error_message'];
    protected $casts = [ 'raw_output' => 'array', 'normalized_fields' => 'array' ];
    public function contract(){ return $this->belongsTo(Contract::class); }
}
