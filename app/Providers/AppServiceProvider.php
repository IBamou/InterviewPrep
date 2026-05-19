<?php

namespace App\Providers;

use App\Services\AiService;
use App\Services\Contracts\AiProvider;
use App\Services\PromptBuilder;
use App\Services\Providers\AnthropicProvider;
use App\Services\Providers\OpenAiCompatibleProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AiProvider::class, function ($app) {
            return match (config('ai.default_provider')) {
                'anthropic' => new AnthropicProvider(),
                default => new OpenAiCompatibleProvider(),
            };
        });

        $this->app->singleton(AiService::class, function ($app) {
            return new AiService(
                $app->make(AiProvider::class),
                $app->make(PromptBuilder::class),
            );
        });
    }

    public function boot(): void
    {
        RateLimiter::for('ai-actions', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(10)->by($request->user()->id)
                : Limit::none();
        });
    }
}
