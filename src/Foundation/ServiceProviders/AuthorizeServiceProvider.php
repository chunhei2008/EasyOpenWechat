<?php
/**
 * AuthorizeServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 00:59
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Foundation\Authorize;
use EasyWeChat\Encryption\Encryptor;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizeServiceProvider implements ServiceProviderInterface
{
    /**
     * Register auth service
     *
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['encryptor'] = function ($pimple) {
            return new Encryptor(
                $pimple['config']['component_app_id'],
                $pimple['config']['token'],
                $pimple['config']['aes_key']
            );
        };

        $pimple['auth'] = function ($pimple) {
            $auth = new Authorize(
                $pimple['config']['token'],
                $pimple['authorize_handler'],
                $pimple['component_verify_ticket'],
                $pimple['authorization'],
                $pimple['authorizer_refresh_token'],
                $pimple['request']
            );

            $auth->debug($pimple['config']['debug']);

            $auth->setEncryptor($pimple['encryptor']);

            return $auth;
        };
    }
}