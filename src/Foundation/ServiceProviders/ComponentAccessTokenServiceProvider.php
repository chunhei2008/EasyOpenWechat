<?php
/**
 * ComponentAccessTokenServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 11:10
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\ComponentAccessToken;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ComponentAccessTokenServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['component_access_token'] = function ($pimple) {
            return new ComponentAccessToken(
                $pimple['config']['component_app_id'],
                $pimple['config']['component_app_secret'],
                $pimple['component_verify_ticket'],
                $pimple['cache']
            );
        };
    }
}