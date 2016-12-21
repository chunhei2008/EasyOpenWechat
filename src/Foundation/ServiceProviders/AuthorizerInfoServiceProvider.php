<?php
/**
 * AuthorizerInfoServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/18 00:42
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\AuthorizerInfo;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerInfoServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['authorizer_info'] = function ($pimple) {
            return new AuthorizerInfo();
        };
    }

}