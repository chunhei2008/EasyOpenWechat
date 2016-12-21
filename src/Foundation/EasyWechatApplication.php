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


use Chunhei2008\EasyOpenWechat\Core\Authorization;
use Chunhei2008\EasyOpenWechat\Core\AuthorizerAccessToken;
use Chunhei2008\EasyOpenWechat\Core\AuthorizerRefreshToken;
use Chunhei2008\EasyOpenWechat\Core\ComponentAccessToken;
use EasyWeChat\Encryption\Encryptor;
use EasyWeChat\Foundation\Application as WechatApplication;

class EasyWechatApplication extends WechatApplication
{

    /**
     * EasyWechatApplication constructor.
     *
     * @param array                  $config
     * @param AuthorizerRefreshToken $authorizerRefreshToken
     * @param ComponentAccessToken   $componentAccessToken
     */
    public function __construct($config, AuthorizerRefreshToken $authorizerRefreshToken, ComponentAccessToken $componentAccessToken, Authorization $authorization)
    {
        parent::__construct($config);
        $this['authorizer_refresh_token'] = $authorizerRefreshToken;
        $this['component_access_token']   = $componentAccessToken;
        $this['authorization']            = $authorization;

        $this->registerBase();
    }

    /**
     * register base provider
     */

    private function registerBase()
    {
        $this->registerServer();
        $this->registerAccessToken();
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
        $this['encryptor'] = function () {
            return new Encryptor(
                $this['config']['component_app_id'],
                $this['config']['token'],
                $this['config']['aes_key']
            );
        };

        $this['server'] = function () {
            $server = new EasyWechatGuard($this);

            $server->debug($this['config']['debug']);

            $server->setEncryptor($this['encryptor']);

            return $server;
        };
    }

}
