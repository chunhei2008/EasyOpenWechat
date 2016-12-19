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
use Chunhei2008\EasyOpenWechat\Support\Log;

class AuthorizeHandler implements AuthorizeHandlerContract
{

    public function componentVerifyTicket($message, ComponentVerifyTicket $componentVerifyTicket)
    {
        Log::debug('ComponentVerifyTicket event:', $message);
        $componentVerifyTicket->setVerifyTicket($message['ComponentVerifyTicket']);
    }

    public function authorized($message, AuthorizationInfo $authorizationInfo)
    {
        Log::debug('Authorized event:', $message);
        $authorizationInfo->setAuthorizationCode($message['AuthorizationCode'])->getAuthorizationInfo();
    }

    public function unauthorized($message)
    {
        Log::debug('Unauthorized event:', $message);
    }

    public function updateauthorized($message, AuthorizationInfo $authorizationInfo)
    {
        Log::debug('Updateauthorized event:', $message);
        $authorizationInfo->setAuthorizationCode('$message[\'AuthorizationCode\']')->getAuthorizationInfo();
    }
}