<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/7/1
 * Time: 21:49
 */

namespace HughCube\Laravel\EasySms\Action;

use HughCube\Laravel\EasySms\EasySms;
use HughCube\Laravel\EasySms\Exceptions\MobileInvalidException;
use HughCube\Laravel\EasySms\Exceptions\ThrottleRequestsException;
use Overtrue\EasySms\Exceptions\InvalidArgumentException;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

trait SendSms
{
    /**
     * @throws InvalidArgumentException
     * @throws ThrottleRequestsException
     * @throws NoGatewayAvailableException
     * @throws MobileInvalidException
     */
    protected function send($mobile, $iddCode, $pinCode): void
    {
        if ($this->skipSendSms()) {
            return;
        }

        EasySms::send(
            $mobile,
            $this->getSmsMessage($mobile, $iddCode, $pinCode),
            $this->getSmsGateways($mobile, $iddCode, $pinCode)
        );
    }

    protected function skipSendSms(): bool
    {
        return true === EasySms::getConfig()->get('skip_send', false);
    }

    /**
     * 需要发送的消息
     *
     * [
     *      'content' => sprintf('您的验证码为: %s', $pinCode),
     *      'template' => $this->getTemplate(),
     *      'data' => ['code' => $pinCode],
     * ]
     */
    abstract protected function getSmsMessage($mobile, $iddCode, $pinCode): array;

    /**
     * 短信发送的网关
     */
    protected function getSmsGateways($mobile, $iddCode, $pinCode): array
    {
        return [];
    }
}
