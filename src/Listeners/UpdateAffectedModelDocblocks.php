<?php


namespace MortenScheel\LaravelIdeHelperPlus\Listeners;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use MortenScheel\LaravelIdeHelperPlus\MigrationQueryRecorder;
use Symfony\Component\Console\Output\StreamOutput;

class UpdateAffectedModelDocblocks
{
    /**
     * @var \MortenScheel\LaravelIdeHelperPlus\MigrationQueryRecorder
     */
    private $recorder;

    /**
     * UpdateAffectedModelDocblocks constructor.
     * @param \MortenScheel\LaravelIdeHelperPlus\MigrationQueryRecorder $recorder
     */
    public function __construct(MigrationQueryRecorder $recorder)
    {
        $this->recorder = $recorder;
    }


    /**
     * Enable query recording
     *
     * @return void
     */
    public function handle()
    {
        if (Config::get('ide-helper-plus.auto-docblocks.enabled') &&
            $this->recorder->isRecording()) {
            $this->recorder->stopRecording();
            $affectedModels = $this->recorder->getAffectedModels();
            if ($affectedModels->isNotEmpty()) {
                $output = new StreamOutput(STDOUT);
                $params = array_merge(Config::get('ide-helper-plus.auto-docblocks.options'), [
                    'model' => $affectedModels->toArray(),
                ]);
                Artisan::call('ide-helper:models', $params, $output);
            }
        }
    }
}
