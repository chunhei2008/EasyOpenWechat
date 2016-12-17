<?php
namespace Chunhei2008\EasyOpenWechat\Foundation;

use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\AuthorizeServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\ComponentAccessTokenServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\ComponentVerifyTicketServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\EasyWechatServiceProvider;
use Pimple\Container;

/**
 * Application.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/15 17:02
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */
class Application extends Container
{
    /**
     * Providers
     * @var array
     */
    protected $providers = [
        AuthorizeServiceProvider::class,
        EasyWechatServiceProvider::class,
        ComponentVerifyTicketServiceProvider::class,
        ComponentAccessTokenServiceProvider::class,
    ];

    public function __construct($config)
    {
        parent::__construct();
        $this->registerProviders();
    }

    /**
     * Register all providers
     */
    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }

}