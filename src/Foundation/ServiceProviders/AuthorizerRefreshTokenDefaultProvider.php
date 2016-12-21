<?php
/**
 * AuthorizerRefreshTokenDefaultProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 11:50
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;

use Chunhei2008\EasyOpenWechat\Core\AuthorizerRefreshToken;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerRefreshTokenDefaultProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['authorizer_refresh_token'] = function ($pimple) {
            return new AuthorizerRefreshToken(
                $pimple['cache']
            );
        };
    }
}