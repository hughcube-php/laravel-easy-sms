<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/18
 * Time: 10:32 下午.
 */

namespace HughCube\Laravel\EasySms;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Overtrue\EasySms\EasySms as EasySmsSdk;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Boot the provider.
     */
    public function boot()
    {
        if ($this->app instanceof LumenApplication) {
            $this->app->configure(EasySms::getFacadeAccessor());
        }
    }

    /**
     * Register the provider.
     */
    public function register()
    {
        $this->app->singleton(EasySms::getFacadeAccessor(), function ($app) {
            $config = $app->make('config')->get(EasySms::getFacadeAccessor(), []);
            return new EasySmsSdk($config);
        });
    }
}
