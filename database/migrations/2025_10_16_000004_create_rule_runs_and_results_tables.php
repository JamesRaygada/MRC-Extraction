<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rule_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->string('ruleset_version');
            $table->enum('status',['Started','Completed','Failed']);
            $table->timestamps();
        });

        Schema::create('rule_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rule_run_id')->constrained('rule_runs')->cascadeOnDelete();
            $table->string('rule_key');
            $table->enum('outcome',['Passed','Failed','NeedsReview']);
            $table->string('risk_score')->nullable();
            $table->json('inputs')->nullable();
            $table->json('evidence')->nullable();
            $table->text('message')->nullable();
            $table->boolean('overridden')->default(false);
            $table->text('override_reason')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('rule_results');
        Schema::dropIfExists('rule_runs');
    }
};
