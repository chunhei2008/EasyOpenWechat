<?php
namespace Chunhei2008\EasyOpenWechat\Foundation;

use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\AuthorizeHandlerServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\AuthorizeServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\ComponentAccessTokenServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\ComponentLoginPageServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\ComponentVerifyTicketServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\EasyWechatServiceProvider;
use Doctrine\Common\Cache\Cache as CacheInterface;
use EasyWeChat\Foundation\Config;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;

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
        ComponentLoginPageServiceProvider::class,
        AuthorizeHandlerServiceProvider::class,
    ];

    public function __construct($config)
    {
        parent::__construct();

        $this['config'] = function () use ($config) {
            return new Config($config);
        };

        if ($this['config']['debug']) {
            error_reporting(E_ALL);
        }

        $this->registerProviders();
        $this->registerBase();
    }

    /**
     * register base provider
     */
    public function registerBase()
    {
        $this['request'] = function () {
            return Request::createFromGlobals();
        };

        if (!empty($this['config']['cache']) && $this['config']['cache'] instanceof CacheInterface) {
            $this['cache'] = $this['config']['cache'];
        } else {
            $this['cache'] = function () {
                return new FilesystemCache(sys_get_temp_dir());
            };
        }
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