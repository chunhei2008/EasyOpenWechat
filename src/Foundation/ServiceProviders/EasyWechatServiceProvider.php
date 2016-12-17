<?php
namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;

use Chunhei2008\EasyOpenWechat\Foundation\EasyWechatApplication;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * EasyWechatServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/15 23:56
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */
class EasyWechatServiceProvider extends ServiceProviderInterface
{
    /**
     * register wechat service
     *
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['wechat'] = function ($pimple) {
            return new EasyWechatApplication($pimple);
        };
    }
}