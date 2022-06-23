<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/18
 * Time: 10:32 下午.
 */

namespace HughCube\Laravel\EasySms;

use Overtrue\EasySms\EasySms as EasySmsSdk;

class ServiceProvider extends \HughCube\Laravel\ServiceSupport\ServiceProvider
{
    protected function getFacadeAccessor(): string
    {
        return EasySms::getFacadeAccessor();
    }

    /**
     * @inheritDoc
     */
    protected function createManager($app)
    {
        $config = $app->make('config')->get($this->getFacadeAccessor(), []);
        return new EasySmsSdk($config);
    }
}
