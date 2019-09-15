<?php


namespace MortenScheel\LaravelIdeHelperPlus\Listeners;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\StreamOutput;

class AutoGenerateMeta
{
    /**
     * Enable query recording
     *
     * @param \Illuminate\Console\Events\CommandFinished $command
     * @return void
     */
    public function handle(CommandFinished $command)
    {
        if ($command->command === 'package:discover') {
            Artisan::call('ide-helper:meta', [], new StreamOutput(STDOUT));
        }
    }
}
