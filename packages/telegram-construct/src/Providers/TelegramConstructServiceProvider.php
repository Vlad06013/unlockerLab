<?php

namespace Valibool\TelegramConstruct\Providers;

use Illuminate\Support\ServiceProvider;
use Valibool\TelegramConstruct\Console\Commands\InstallSwagger;

class TelegramConstructServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
//        $this->publishes([
//            __DIR__ . '/../../config/telegram-construct.php' => config_path('telegram-construct.php'),
//        ]);
//        if (is_dir('app/Orchid')) {
//            $this->publishes([
//                __DIR__ . '/../../src/Orchid/Screens' => 'app/Orchid/Screens',
//            ]);
//
//        }

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

//        $this->commands([
////            InstallCommand::class,
//            InstallSwagger::class,
//        ]);

        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
    }
}
