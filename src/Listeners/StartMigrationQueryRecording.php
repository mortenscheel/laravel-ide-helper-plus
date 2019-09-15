<?php


namespace MortenScheel\LaravelIdeHelperPlus\Listeners;

use MortenScheel\LaravelIdeHelperPlus\MigrationQueryRecorder;

class StartMigrationQueryRecording
{
    /**
     * @var \MortenScheel\LaravelIdeHelperPlus\MigrationQueryRecorder
     */
    private $recorder;

    /**
     * StartMigrationQueryRecording constructor.
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
        $this->recorder->startRecording();
    }
}
