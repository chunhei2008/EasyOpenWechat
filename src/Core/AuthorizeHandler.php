<?php
/**
 * AuthorizeHandler.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 14:23
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;


use Chunhei2008\EasyOpenWechat\Contracts\AuthorizeHandlerContract;
use Chunhei2008\EasyOpenWechat\Contracts\AuthorizerRefreshTokenContract;
use Chunhei2008\EasyOpenWechat\Support\Log;

class AuthorizeHandler implements AuthorizeHandlerContract
{

    public function componentVerifyTicket($message, ComponentVerifyTicket $componentVerifyTicket)
    {
        Log::debug('ComponentVerifyTicket event:', $message);
        $componentVerifyTicket->setVerifyTicket($message['ComponentVerifyTicket']);
    }

    public function authorized($message, Authorization $authorization)
    {
        Log::debug('Authorized event:', $message);
        $authorization->setAuthorizationCode($message['AuthorizationCode'])->getAuthorizationInfo();
    }

    public function unauthorized($message, AuthorizerRefreshTokenContract $authorizerRefreshToken)
    {
        Log::debug('Unauthorized event:', $message);
        $authorizerRefreshToken->removeRefreshToken($message['AuthorizerAppid']);
    }

    public function updateauthorized($message, Authorization $authorization)
    {
        Log::debug('Updateauthorized event:', $message);
        $authorization->setAuthorizationCode($message['AuthorizationCode'])->getAuthorizationInfo();
    }
}