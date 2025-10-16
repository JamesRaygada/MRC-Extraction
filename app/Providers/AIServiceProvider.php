<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AI\{AIProviderInterface, OpenAIProvider};

class AIServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->bind(AIProviderInterface::class, fn() => new OpenAIProvider(config('ai.model')));
    }
}
