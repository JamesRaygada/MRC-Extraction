<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewComment extends Model {
    use HasFactory;
    protected $fillable = ['contract_id','author','body'];
    public function contract(){ return $this->belongsTo(Contract::class); }
}
