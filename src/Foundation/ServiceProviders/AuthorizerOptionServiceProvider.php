<?php
/**
 * AuthorizerOptionServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/21 16:53
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\AuthorizerOption;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerOptionServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['option'] = function ($pimple) {
            return new AuthorizerOption(
                $pimple['config']['component_app_id'],
                $pimple['component_access_token']
            );
        };
    }
}