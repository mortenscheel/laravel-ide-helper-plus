<?php


namespace MortenScheel\LaravelIdeHelperPlus\Tests\Feature;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use MortenScheel\LaravelIdeHelperPlus\Tests\TestCase;

class MetaFileTest extends TestCase
{
    public function testIdeHelperFileIsNotGeneratedWhenConfigIsNotEnabled()
    {
        Config::set('ide-helper-plus.auto-meta.enabled', false);
        $expected_path = $this->getTestbenchPath() . '/.phpstorm.meta.php';
        $this->assertFileNotExists($expected_path);
        Artisan::call('package:discover');
        $this->assertFileNotExists($expected_path);
    }

    public function testMetaFileIsGeneratedWhenConfigEnabled()
    {
        Config::set('ide-helper-plus.auto-meta.enabled', true);
        $expected_path = $this->getTestbenchPath() . '/.phpstorm.meta.php';
        $this->assertFileNotExists($expected_path);
        Artisan::call('package:discover');
        $this->assertFileExists($expected_path);
    }
}
