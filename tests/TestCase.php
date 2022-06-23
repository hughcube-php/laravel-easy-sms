<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/20
 * Time: 11:36 下午.
 */

namespace HughCube\Laravel\EasySms\Tests;

use HughCube\Laravel\EasySms\ServiceProvider as EasySmsServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * @param Application $app
     *
     * @return void
     */
    protected function getPackageProviders($app)
    {
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
    }
}
