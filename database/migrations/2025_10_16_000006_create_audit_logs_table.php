<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('actor')->nullable();
            $table->string('action');
            $table->morphs('auditable');
            $table->json('meta')->nullable();
            $table->timestamp('created_at');
        });
    }
    public function down(): void { Schema::dropIfExists('audit_logs'); }
};
