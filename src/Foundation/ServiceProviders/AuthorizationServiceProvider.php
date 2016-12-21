<?php
/**
 * AuthorizationServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/21 16:09
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\Authorization;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizationServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['authorization'] = function ($pimple) {
            return new Authorization(
                $pimple['config']['component_app_id'],
                $pimple['component_access_token'],
                $pimple['authorizer_access_token'],
                $pimple['authorizer_refresh_token'],
                $pimple['authorization_info'],
                $pimple['cache']
            );
        };
    }

}