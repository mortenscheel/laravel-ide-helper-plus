<?php

namespace MortenScheel\LaravelIdeHelperPlus;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use MortenScheel\LaravelIdeHelperPlus\Listeners\AutoGenerateIdeHelper;
use MortenScheel\LaravelIdeHelperPlus\Listeners\AutoGenerateMeta;
use MortenScheel\LaravelIdeHelperPlus\Listeners\RecordMigrationQuery;
use MortenScheel\LaravelIdeHelperPlus\Listeners\StartMigrationQueryRecording;
use MortenScheel\LaravelIdeHelperPlus\Listeners\UpdateAffectedModelDocblocks;

class LaravelIdeHelperPlusServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/ide-helper-plus.php' => config_path('ide-helper-plus.php'),
            ], 'ide-helper-plus');
            if (Config::get('ide-helper-plus.auto-docblocks.enabled', false) &&
                version_compare($this->app->version(), '5.8.16')) {
                Event::listen(MigrationsStarted::class, StartMigrationQueryRecording::class);
                Event::listen(QueryExecuted::class, RecordMigrationQuery::class);
                Event::listen(MigrationsEnded::class, UpdateAffectedModelDocblocks::class);
            }
            if (Config::get('ide-helper-plus.auto-generate.enabled')) {
                Event::listen(CommandFinished::class, AutoGenerateIdeHelper::class);
            }
            if (Config::get('ide-helper-plus.auto-meta.enabled')) {
                Event::listen(CommandFinished::class, AutoGenerateMeta::class);
            }
        }
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ide-helper-plus.php', 'ide-helper-plus');
        $this->app->singleton(MigrationQueryRecorder::class, function () {
            return new \MortenScheel\LaravelIdeHelperPlus\MigrationQueryRecorder;
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [MigrationQueryRecorder::class];
    }
}
