<?php

namespace FreePlaceholder;

use FreePlaceholder\Views\Components\Avatar;
use FreePlaceholder\Views\Components\Placeholder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FreePlaceholderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/freeplaceholder.php' => config_path('freeplaceholder.php'),
        ], 'freeplaceholder-config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'freeplaceholder');

        $this->registerBladeComponents();
        $this->registerBladeDirectives();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/freeplaceholder.php', 'freeplaceholder');

        $this->app->singleton(FreePlaceholderManager::class, function () {
            return new FreePlaceholderManager(
                config('freeplaceholder.base_url', 'https://freeplaceholder.com')
            );
        });
    }

    protected function registerBladeComponents(): void
    {
        Blade::component('placeholder', Placeholder::class);
        Blade::component('avatar', Avatar::class);
    }

    protected function registerBladeDirectives(): void
    {
        Blade::directive('placeholder', function (string $expression) {
            return "<?php echo app(\FreePlaceholder\FreePlaceholderManager::class)->renderPlaceholderDirective({$expression}); ?>";
        });

        Blade::directive('avatar', function (string $expression) {
            return "<?php echo app(\FreePlaceholder\FreePlaceholderManager::class)->renderAvatarDirective({$expression}); ?>";
        });
    }
}
