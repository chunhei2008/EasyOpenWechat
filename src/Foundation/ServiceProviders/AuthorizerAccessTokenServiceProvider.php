<?php
/**
 * AuthorizerAccessTokenServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/19 18:03
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\AuthorizerAccessToken;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerAccessTokenServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['authorizer_access_token'] = function ($pimple) {
            return new AuthorizerAccessToken(
                $pimple['config']['component_app_id'],
                $pimple['config']['app_id'],
                $pimple['authorizer_refresh_token'],
                $pimple['component_access_token'],
                $pimple['cache']
            );
        };
    }
}