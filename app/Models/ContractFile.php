<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractFile extends Model {
    use HasFactory;
    protected $fillable = ['contract_id','kind','original_name','mime','size_bytes','disk','path','sha256','clamav_passed'];
    public function contract(){ return $this->belongsTo(Contract::class); }
}
