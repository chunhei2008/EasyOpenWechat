<?php
/**
 * AuthorizerAccessToken.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/16 00:18
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;

use Chunhei2008\EasyOpenWechat\Contracts\AuthorizerRefreshTokenContract;
use Chunhei2008\EasyOpenWechat\Support\Log;
use Doctrine\Common\Cache\Cache;
use EasyWeChat\Core\AccessToken;
use EasyWeChat\Core\Exceptions\HttpException;

class AuthorizerAccessToken extends AccessToken
{
    /**
     * api
     */
    const API_AUTHORIZER_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=';

    /*
     * component app id
     *
     * @var string
     */

    protected $componentAppId;

    /**
     * authorizer app id
     * @var string
     */

    protected $authorizerAppId;

    /**
     * authorizer refresh token
     * @var Cache
     */

    protected $authorizerRefreshToken;

    /**
     * component access token
     *
     * @var
     */
    protected $componentAccessToken;

    /**
     * Cache key prefix.
     *
     * @var string
     */
    protected $prefix = 'easyopenwechat.core.authorizer_access_token.';


    public function __construct($componentAppId, $authorizerAppId = '', AuthorizerRefreshTokenContract $authorizerRefreshToken, ComponentAccessToken $componentAccessToken, Cache $cache = null)
    {
        $this->componentAppId         = $componentAppId;
        $this->authorizerAppId        = $this->appId = $authorizerAppId;
        $this->authorizerRefreshToken = $authorizerRefreshToken;
        $this->componentAccessToken   = $componentAccessToken;
        $this->cache                  = $cache;
    }


    /**
     * Get token from WeChat API.
     *
     * @param bool $forceRefresh
     *
     * @return string
     */
    public function getToken($forceRefresh = false)
    {
        $cacheKey = $this->getCacheKey();
        $cached   = $this->getCache()->fetch($cacheKey);

        if ($forceRefresh || empty($cached)) {
            $token = $this->getTokenFromServer();

            // XXX: T_T... 7200 - 1500
            $this->getCache()->save($cacheKey, $token['authorizer_access_token'], $token['expires_in'] - 1500);
            Log::debug('Get token:', $token);
            return $token['authorizer_access_token'];
        }
        Log::debug('Get token from cache:', [$cached]);
        return $cached;
    }


    /**
     * Get the access token from WeChat server.
     *
     * @throws \EasyWeChat\Core\Exceptions\HttpException
     *
     * @return string
     */
    public function getTokenFromServer()
    {
        $params = [
            'json' => [
                'component_appid'          => $this->componentAppId,
                'authorizer_appid'         => $this->authorizerAppId,
                'authorizer_refresh_token' => $this->authorizerRefreshToken->getRefreshToken($this->authorizerAppId),
            ],
        ];

        $http = $this->getHttp();

        $token = $http->parseJSON($http->request(self::API_AUTHORIZER_TOKEN . $this->componentAccessToken->getToken(), 'POST', $params));

        if (empty($token['authorizer_access_token'])) {
            throw new HttpException('Request AccessToken fail. response: ' . json_encode($token, JSON_UNESCAPED_UNICODE));
        }

        return $token;
    }

    /**
     *
     * set authorizer App Id
     *
     * @param $authorizerAppId
     *
     * @return $this
     */
    public function setAuthorizerAppId($authorizerAppId)
    {
        $this->authorizerAppId = $this->appId = $authorizerAppId;
        return $this;
    }
}
