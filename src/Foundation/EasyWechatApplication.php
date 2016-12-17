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
use EasyWeChat\Foundation\Application;

class EasyWechatApplication extends Application
{
    /**
     * Application constructor.
     *
     * @param array $config
     */
    public function __construct($config)
    {
        parent::__construct($config);
        $this->registerApp();
        $this->registerServer();
        $this->registerAccessToken();
    }

    /**
     * Register app
     */
    private function registerApp()
    {
        $this['app'] = $this;
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
                $this['config']['refresh_token'],   //TODO
                $this['config']['component_access_token'],
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
