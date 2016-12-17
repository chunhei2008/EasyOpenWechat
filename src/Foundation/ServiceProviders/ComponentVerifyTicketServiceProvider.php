<?php
/**
 * ComponentVerifyTicketServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 11:15
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\ComponentVerifyTicket;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ComponentVerifyTicketServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['component_verify_ticket'] = function ($pimple) {
            return new ComponentVerifyTicket(
                $pimple['component_app_id'],
                $pimple['cache']
            );
        };
    }

}