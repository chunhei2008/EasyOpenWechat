<?php
/**
 * AuthorizationServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/21 15:51
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\AuthorizationInfo;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizationInfoServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['authorization_info'] = function ($pimple) {
            return new AuthorizationInfo();
        };
    }
}