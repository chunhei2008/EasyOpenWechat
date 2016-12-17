<?php
/**
 * AuthorizeHandlerServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 16:34
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\AuthorizeHandler;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizeHandlerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['authorize_handler'] = function ($pimple) {
            return new AuthorizeHandler();
        };
    }

}