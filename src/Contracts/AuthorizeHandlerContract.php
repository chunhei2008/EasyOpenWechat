<?php
namespace Chunhei2008\EasyOpenWechat\Contracts;

use Chunhei2008\EasyOpenWechat\Core\ComponentVerifyTicket;


/**
 * AuthPushContract.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/16 09:25
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */
interface AuthorizeHandlerContract
{
    /**
     * handle component verify ticket
     *
     * @param                       $message
     * @param ComponentVerifyTicket $componentVerifyTicket
     *
     * @return mixed
     */

    public function componentVerifyTicket($message, ComponentVerifyTicket $componentVerifyTicket);

    /**
     * handle authorized
     *
     * @param $message
     *
     * @return mixed
     */
    public function authorized($message);

    /**
     * handle unauthorized
     *
     * @param $message
     *
     * @return mixed
     */
    public function unauthorized($message);

    /**
     *
     * handle updateauthorized
     *
     * @param $message
     *
     * @return mixed
     */

    public function updateauthorized($message);

}