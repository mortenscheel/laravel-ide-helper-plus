<?php

namespace MortenScheel\LaravelIdeHelperPlus\Tests;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use MortenScheel\LaravelIdeHelperPlus\LaravelIdeHelperPlusServiceProvider;
use Orchestra\Testbench\TestCase as TestBench;
use Symfony\Component\Process\Process;

abstract class TestCase extends TestBench
{
    use RefreshDatabase;

    protected $debug = false;

    protected function getTestbenchPath()
    {
        $relative = __DIR__ . '/../vendor/orchestra/testbench-core/laravel';
        return realpath($relative);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelIdeHelperPlusServiceProvider::class,
            IdeHelperServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupGitRepository();
    }

    protected function tearDown(): void
    {
        $this->resetRepository();
        $this->deleteRepository();
        parent::tearDown();
    }

    protected function executeCommand($command)
    {
        $cwd = $this->getTestbenchPath();
        if (is_string($command)) {
            $command = explode(' ', $command);
        }
        $process = new Process($command, $cwd);
        $process->setTimeout(null);
        $callback = null;
        if ($this->debug) {
            $callback = function ($type, $buffer) {
                fwrite(STDOUT, $buffer);
            };
        }
        $process->run($callback);
        return $process->getExitCode() === 0;
    }

    protected function setupGitRepository()
    {
        $git_path = base_path('.git');
        if (File::exists($git_path) && File::isDirectory($git_path)) {
            $this->resetRepository();
            $this->deleteRepository();
        }
        return $this->executeCommand('git init') &&
            $this->executeCommand('git add .') &&
            $this->executeCommand('git commit -m "Initial"');
    }

    protected function resetRepository()
    {
        return $this->executeCommand('git reset --hard') &&
            $this->executeCommand('git clean -dxf');
    }

    protected function deleteRepository()
    {
        $path = base_path('.git');
        if (File::exists($path) && File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
    }
}
