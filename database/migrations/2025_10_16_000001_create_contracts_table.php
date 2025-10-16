<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->string('title');
            $table->string('uploader_email')->nullable();
            $table->enum('status', ['Pending','Extracted','Checked','NeedsReview','ExtractionFailed','ProcessingError'])
                  ->default('Pending');
            $table->string('risk_level')->nullable();
            $table->json('risk_summary')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('contracts'); }
};
