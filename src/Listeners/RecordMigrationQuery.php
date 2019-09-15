<?php


namespace MortenScheel\LaravelIdeHelperPlus\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use MortenScheel\LaravelIdeHelperPlus\MigrationQueryRecorder;

class RecordMigrationQuery
{
    /**
     * @var \MortenScheel\LaravelIdeHelperPlus\MigrationQueryRecorder
     */
    private $recorder;

    /**
     * RecordMigrationQuery constructor.
     * @param \MortenScheel\LaravelIdeHelperPlus\MigrationQueryRecorder $recorder
     */
    public function __construct(MigrationQueryRecorder $recorder)
    {
        $this->recorder = $recorder;
    }

    /**
     * Enable query recording
     *
     * @param \Illuminate\Database\Events\QueryExecuted $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        if ($this->recorder->isRecording()) {
            $this->recorder->recordQuery($event->sql);
        }
    }
}
