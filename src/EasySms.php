<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/18
 * Time: 10:31 下午.
 */

namespace HughCube\Laravel\EasySms;

use Closure;
use Illuminate\Support\Facades\Facade as IlluminateFacade;

/**
 * Class Package.
 *
 * @method static array send($to, $message, array $gateways = [])
 * @method static \Overtrue\EasySms\Contracts\GatewayInterface gateway($name)
 * @method static \Overtrue\EasySms\Contracts\StrategyInterface strategy($strategy = null)
 * @method static \Overtrue\EasySms\EasySms extend($name, Closure $callback)
 * @method static \Overtrue\EasySms\Support\Config getConfig()
 * @method static \Overtrue\EasySms\Messenger getMessenger()
 *
 * @see \Overtrue\EasySms\EasySms
 * @see \HughCube\Laravel\EasySms\ServiceProvider
 */
class EasySms extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'easySms';
    }
}
