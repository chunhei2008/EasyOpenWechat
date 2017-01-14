<?php
/**
 * AuthorizerServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/21 15:44
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\Authorizer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['authorizer'] = function ($pimple) {
            return new Authorizer(
                $pimple['config']['component_app_id'],
                $pimple['component_access_token'],
                $pimple['authorizer_info']
            );
        };

    }
}