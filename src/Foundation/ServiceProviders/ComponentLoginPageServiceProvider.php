<?php
/**
 * ComponentLoginPageServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 16:07
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\ComponentLoginPage;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ComponentLoginPageServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['login'] = function ($pimple) {
            return new ComponentLoginPage(
                $pimple['config']['component_app_id'],
                $pimple['pre_auth_code'],
                $pimple['config']['redirect_uri']
            );
        };
    }

}