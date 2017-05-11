<?php
/**
 * OpenOAuthServiceProvider.php
 *
 * Author: luqugu <luqugu@outlook.com>
 *
 * Date:   2017/5/11 00:00
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Overtrue\Socialite\SocialiteManager as Socialite;

/**
 * Class OpenOAuthServiceProvider.
 */
class OpenOAuthServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['oauth'] = function ($pimple) {
            $callback = $this->prepareCallbackUrl($pimple);
            $scopes = $pimple['config']->get('oauth.scopes', []);
            $socialite = (new Socialite(
                [
                    'wechat_open' => [
                        'client_id' => $pimple['config']['app_id'],
                        'client_secret' => [
                            $pimple['config']['component_app_id'],
                            $pimple['component_access_token']->getToken()
                        ],
                        'redirect' => $callback,
                    ],
                ]
            ))->driver('wechat_open');

            if (!empty($scopes)) {
                $socialite->scopes($scopes);
            }

            return $socialite;
        };
    }

    /**
     * Prepare the OAuth callback url for wechat.
     *
     * @param Container $pimple
     *
     * @return string
     */
    private function prepareCallbackUrl($pimple)
    {
        $callback = $pimple['config']->get('oauth.callback');
        if (0 === stripos($callback, 'http')) {
            return $callback;
        }
        $baseUrl = $pimple['request']->getSchemeAndHttpHost();
        return $baseUrl . '/' . ltrim($callback, '/');
    }
}
