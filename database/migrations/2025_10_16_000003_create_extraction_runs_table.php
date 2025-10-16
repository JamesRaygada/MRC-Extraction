<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('extraction_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->string('engine');
            $table->string('engine_version')->nullable();
            $table->enum('status', ['Started','Succeeded','Failed']);
            $table->json('raw_output')->nullable();
            $table->json('normalized_fields')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('extraction_runs'); }
};
