<?php
namespace Chunhei2008\EasyOpenWechat\Foundation;

use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\AuthorizationInfoServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\AuthorizeHandlerServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\AuthorizerRefreshTokenDefaultProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\AuthorizeServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\ComponentAccessTokenServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\ComponentLoginPageServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\ComponentVerifyTicketServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\EasyWechatServiceProvider;
use Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders\PreAuthCodeServiceProvider;
use Chunhei2008\EasyOpenWechat\Support\Log;
use Doctrine\Common\Cache\Cache as CacheInterface;
use Doctrine\Common\Cache\FilesystemCache;
use EasyWeChat\Foundation\Config;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
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
        ComponentVerifyTicketServiceProvider::class,
        AuthorizeHandlerServiceProvider::class,
        AuthorizeServiceProvider::class,
        AuthorizerRefreshTokenDefaultProvider::class,
        ComponentAccessTokenServiceProvider::class,
        PreAuthCodeServiceProvider::class,
        ComponentLoginPageServiceProvider::class,
        AuthorizationInfoServiceProvider::class,
        AuthorizeServiceProvider::class,
        EasyWechatServiceProvider::class,
    ];

    public function __construct($config)
    {
        parent::__construct($config);

        $this['config'] = function () use ($config) {
            return new Config($config);
        };

        if ($this['config']['debug']) {
            error_reporting(E_ALL);
        }

        $this->registerBase();
        $this->registerProviders();
        $this->initializeLogger();
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

    /**
     * Initialize logger.
     */
    private function initializeLogger()
    {
        if (Log::hasLogger()) {
            return;
        }

        $logger = new Logger('easyopenwechat');

        if (!$this['config']['debug'] || defined('PHPUNIT_RUNNING')) {
            $logger->pushHandler(new NullHandler());
        } elseif ($this['config']['log.handler'] instanceof HandlerInterface) {
            $logger->pushHandler($this['config']['log.handler']);
        } elseif ($logFile = $this['config']['log.file']) {
            $logger->pushHandler(new StreamHandler($logFile, $this['config']->get('log.level', Logger::WARNING)));
        }

        Log::setLogger($logger);
    }
}