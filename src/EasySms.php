<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/18
 * Time: 10:31 下午.
 */

namespace HughCube\Laravel\EasySms;

use Closure;
use HughCube\Laravel\EasySms\Exceptions\MobileInvalidException;
use HughCube\Laravel\EasySms\Exceptions\ThrottleRequestsException;
use HughCube\Laravel\ServiceSupport\LazyFacade;
use Illuminate\Support\Arr;
use Overtrue\EasySms\Exceptions\InvalidArgumentException;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

/**
 * Class Package.
 *
 * @method static \Overtrue\EasySms\Contracts\GatewayInterface gateway($name)
 * @method static \Overtrue\EasySms\Contracts\StrategyInterface strategy($strategy = null)
 * @method static \Overtrue\EasySms\EasySms extend($name, Closure $callback)
 * @method static \Overtrue\EasySms\Support\Config getConfig()
 * @method static \Overtrue\EasySms\Messenger getMessenger()
 *
 * @see \Overtrue\EasySms\EasySms
 * @see \HughCube\Laravel\EasySms\ServiceProvider
 */
class EasySms extends LazyFacade
{
    protected static $skipSendCallable = null;

    /**
     * @inheritDoc
     */
    public static function getFacadeAccessor(): string
    {
        return 'easysms';
    }

    /**
     * @inheritDoc
     */
    protected static function registerServiceProvider($app)
    {
        $app->register(ServiceProvider::class);
    }

    /**
     * 是否发送短信
     */
    public static function isSkipSend($to = null): bool
    {
        /** @var \Overtrue\EasySms\EasySms $sender */
        $sender = static::getFacadeRoot();

        if (true === $sender->getConfig()->get('skip_send', false)) {
            return true;
        }

        if (is_callable(static::$skipSendCallable) && true === call_user_func(static::$skipSendCallable, $to)) {
            return true;
        }

        return false;
    }

    /**
     * @throws InvalidArgumentException
     * @throws MobileInvalidException
     * @throws NoGatewayAvailableException
     * @throws ThrottleRequestsException
     */
    public static function forceSend($to, $message, array $gateways = []): array
    {
        /** @var \Overtrue\EasySms\EasySms $sender */
        $sender = static::getFacadeRoot();

        try {
            return $sender->send($to, $message, $gateways);
        } catch (NoGatewayAvailableException $exception) {
        }

        /** 处理阿里云的情况 */
        foreach ($exception->getExceptions() as $exception) {
            if (property_exists($exception, 'raw')) {
                $code = Arr::get($exception->raw, 'Code');
                if ($code == 'isv.BUSINESS_LIMIT_CONTROL') {
                    throw new ThrottleRequestsException('短信发送太频繁了, 请稍后再试!');
                }

                if ($code == 'isv.MOBILE_NUMBER_ILLEGAL') {
                    throw new MobileInvalidException('手机号码错误!');
                }
            }
        }

        throw $exception;
    }

    /**
     * @throws MobileInvalidException
     * @throws InvalidArgumentException
     * @throws ThrottleRequestsException
     * @throws NoGatewayAvailableException
     */
    public static function send($to, $message, array $gateways = []): array
    {
        if (static::isSkipSend()) {
            return [];
        }


        return static::forceSend($to, $message, $gateways);
    }

    public static function useSkipSendCallable(callable $callable)
    {
        static::$skipSendCallable = $callable;
    }
}
