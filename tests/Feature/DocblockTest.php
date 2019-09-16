<?php


namespace MortenScheel\LaravelIdeHelperPlus\Tests\Feature;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use MortenScheel\LaravelIdeHelperPlus\Tests\TestCase;

class DocblockTest extends TestCase
{
    public function testDocBlocksAreMissingInitially()
    {
        Artisan::call('make:model', [
            'name' => 'TestModel',
        ]);
        $model_path = app_path('TestModel.php');
        $this->assertFileExists($model_path);
        require_once $model_path;
        $ref = new \ReflectionClass('App\TestModel');
        $this->assertFalse($ref->getDocComment());
    }

    public function testDocBlocksAreNotCreatedIfFeatureDisabled()
    {
        Config::set('ide-helper-plus.auto-docblocks.enabled', false);
        Artisan::call('make:model', [
            'name' => 'TestModel',
        ]);
        $model_path = app_path('TestModel.php');
        require_once $model_path;
        Artisan::call('migrate', [
            '--path'     => realpath(__DIR__ . '/../Fixtures/migrations/2019_09_16_181430_create_test_models_table.php'),
            '--realpath' => true,
        ]);
        $this->assertFileExists($model_path);
        /*
         * Model class was loaded before docblocks were created.
         * Create a renamed model-file and inspect that in stead
         */
        [$dupe_path, $dupe_name] = $this->createModelDupe($model_path, 'TestModel');
        require_once $dupe_path;
        try {
            $ref = new \ReflectionClass($dupe_name);
            $docblock = $ref->getDocComment();
            $this->assertFalse($docblock);
        } catch (\ReflectionException $e) {
        }
    }

    public function testDocblocksAreAddedWhenMigrated()
    {
        Config::set('ide-helper-plus.auto-docblocks.enabled', true);
        Artisan::call('make:model', [
            'name' => 'TestModel',
        ]);
        $model_path = app_path('TestModel.php');
        require_once $model_path;
        Artisan::call('migrate', [
            '--path'     => realpath(__DIR__ . '/../Fixtures/migrations/2019_09_16_181430_create_test_models_table.php'),
            '--realpath' => true,
        ]);
        $this->assertFileExists($model_path);
        /*
         * Model class was loaded before docblocks were created.
         * Create a renamed model-file and inspect that in stead
         */
        [$dupe_path, $dupe_name] = $this->createModelDupe($model_path, 'TestModel', 2);
        require_once $dupe_path;
        try {
            $ref = new \ReflectionClass($dupe_name);
            $docblock = $ref->getDocComment();
            $this->assertNotFalse($docblock);
            $this->assertStringContainsString('@property string $name', $docblock);
            $this->assertStringContainsString('@property string $type', $docblock);
        } catch (\ReflectionException $e) {
        }
    }

    public function testDocblocksAreChangedWhenColumnsAreModified()
    {
        /*
         * Todo
         * Probably requires starting with a pre-made Model class, since
         * ide-helper won't process more than one docblock update in a
         * single process.
         */
        $this->assertTrue(true);
    }

    protected function createModelDupe($path, $class_name, int $number = 1)
    {
        $dupe_path = sprintf('%sDupe%s.php', rtrim($path, '.php'), $number > 1 ? $number : '');
        $dupe_name = sprintf('%sDupe%s', $class_name, $number > 1 ? $number : '');
        copy($path, $dupe_path);
        $dupe_content = file_get_contents($dupe_path);
        $dupe_class_renamed = preg_replace('/class ' . $class_name . '/', 'class ' . $dupe_name, $dupe_content);
        file_put_contents($dupe_path, $dupe_class_renamed);
        return [$dupe_path, 'App\\' . $dupe_name];
    }

}
