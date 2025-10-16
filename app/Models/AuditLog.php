<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model {
    public $timestamps = false;
    protected $fillable = ['actor','action','auditable_type','auditable_id','meta','created_at'];
    protected $casts = [ 'meta' => 'array', 'created_at' => 'datetime' ];
    public function auditable(){ return $this->morphTo(); }
}
