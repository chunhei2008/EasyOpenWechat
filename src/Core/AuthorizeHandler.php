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

class AuthorizeHandler implements AuthorizeHandlerContract
{

    public function componentVerifyTicket($message, ComponentVerifyTicket $componentVerifyTicket)
    {
        $componentVerifyTicket->setVerifyTicket($message['ComponentVerifyTicket']);
    }

    public function authorized($message)
    {
        // TODO: Implement authorized() method.
    }

    public function unauthorized($message)
    {
        // TODO: Implement unauthorized() method.
    }

    public function updateauthorized($message)
    {
        // TODO: Implement updateauthorized() method.
    }
}