<?php


namespace MortenScheel\LaravelIdeHelperPlus\Listeners;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Output\StreamOutput;

class AutoGenerateIdeHelperFile
{
    /**
     * Enable query recording
     *
     * @param \Illuminate\Console\Events\CommandFinished $command
     * @return void
     */
    public function handle(CommandFinished $command)
    {
        if (
            $command->command === 'package:discover' &&
            Config::get('ide-helper-plus.auto-generate.enabled')
        ) {
            Artisan::call('ide-helper:generate', [
                'filename' => base_path('_ide_helper.php')
            ], new StreamOutput(STDOUT));
        }
    }
}
