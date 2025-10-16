<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contract_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->enum('kind', ['primary','spreadsheet','other']);
            $table->string('original_name');
            $table->string('mime');
            $table->unsignedBigInteger('size_bytes');
            $table->string('disk');
            $table->string('path');
            $table->string('sha256');
            $table->boolean('clamav_passed')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('contract_files'); }
};
