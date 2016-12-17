<?php
/**
 * PreAuthCodeServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/18 00:00
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\PreAuthCode;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class PreAuthCodeServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['pre_auth_code'] = function ($pimple) {
            return new PreAuthCode(
                $pimple['config']['component_app_id'],
                $pimple['component_access_token']
            );
        };
    }
}