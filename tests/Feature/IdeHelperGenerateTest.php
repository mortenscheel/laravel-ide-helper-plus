<?php


namespace MortenScheel\LaravelIdeHelperPlus\Tests\Feature;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use MortenScheel\LaravelIdeHelperPlus\Tests\TestCase;

class IdeHelperGenerateTest extends TestCase
{
    public function testIdeHelperFileIsGeneratedWhenConfigEnabled()
    {
        Config::set('ide-helper-plus.auto-generate.enabled', true);
        $expected_path = $this->getTestbenchPath() . '/_ide-helper.php';
        $this->assertFileNotExists($expected_path);
        Artisan::call('package:discover');
        $this->assertFileExists($expected_path);
    }

    public function testIdeHelperFileIsNotGeneratedWhenConfigIsNotEnabled()
    {
        Config::set('ide-helper-plus.auto-generate.enabled', false);
        $expected_path = $this->getTestbenchPath() . '/_ide-helper.php';
        $this->assertFileNotExists($expected_path);
        Artisan::call('package:discover');
        $this->assertFileNotExists($expected_path);
    }
}
