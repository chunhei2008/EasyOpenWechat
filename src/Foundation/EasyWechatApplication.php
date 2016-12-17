<?php
/**
 * EasyWechatApplication.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/16 00:07
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation;


use Chunhei2008\EasyOpenWechat\Core\AuthorizerAccessToken;
use Chunhei2008\EasyOpenWechat\Foundation\Application as EasyOpenWechatApplication;
use EasyWeChat\Foundation\Application;

class EasyWechatApplication extends Application
{
    /**
     * easy open wechat application
     * @var
     */

    protected $easyOpenWechatApplication;

    /**
     * Application constructor.
     *
     * @param array $config
     */
    public function __construct(EasyOpenWechatApplication $app)
    {
        parent::__construct($app['config']);
        $this->easyOpenWechatApplication = $app;
        $this->registerBase();
    }

    private function registerBase()
    {
        $this->registerApp();
        $this->registerServer();
        $this->registerComponentAccessToken();
        $this->registerAuthorizerRefreshToken();
        $this->registerAccessToken();
    }

    /**
     * Register app
     */
    private function registerApp()
    {
        $this['app'] = $this;
    }

    private function registerAuthorizerRefreshToken()
    {
        $this['authorizer_refresh_token'] = $this->easyOpenWechatApplication['authorizer_refresh_token'];
    }

    private function registerComponentAccessToken()
    {
        $this['component_access_token'] = $this->easyOpenWechatApplication['component_access_token'];
    }

    /**
     * Register basic providers.
     */
    private function registerAccessToken()
    {
        $this['access_token'] = function () {
            return new AuthorizerAccessToken(
                $this['config']['component_app_id'],
                $this['config']['app_id'],
                $this['authorizer_refresh_token'],
                $this['component_access_token'],
                $this['cache']
            );
        };
    }

    /**
     * Register Server providers.
     */
    private function registerServer()
    {
        $this['server'] = function ($pimple) {
            $server = new EasyWechatGuard($pimple['app']);

            $server->debug($pimple['config']['debug']);

            $server->setEncryptor($pimple['encryptor']);

            return $server;
        };
    }

}
