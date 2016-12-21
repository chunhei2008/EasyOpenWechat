<?php
/**
 * ComponentAccessToken.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/16 00:15
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;


use Chunhei2008\EasyOpenWechat\Support\Log;
use Chunhei2008\EasyOpenWechat\Traits\CacheTrait;
use Chunhei2008\EasyOpenWechat\Traits\HttpTrait;
use Doctrine\Common\Cache\Cache;
use EasyWeChat\Core\Exceptions\HttpException;

class ComponentAccessToken
{
    use HttpTrait, CacheTrait;

    /**
     * api
     */
    const API_COMPONENT_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';


    /**
     * cache key prefix
     *
     */
    const COMPONENT_ACCESS_TOKEN_CACHE_PREFIX = 'easyopenwechat.core.component_access_token.';

    /**
     * component app id
     * @var
     */

    protected $componentAppId;

    /**
     *
     * component app secret
     *
     * @var
     */

    protected $componentAppSecret;


    /**
     *
     * component verify ticket
     *
     * @var
     */

    protected $componentVerifyTicket;

    public function __construct($componentAppId, $componentAppSecret, ComponentVerifyTicket $componentVerifyTicket, Cache $cache = null)
    {
        $this->componentAppId        = $componentAppId;
        $this->componentAppSecret    = $componentAppSecret;
        $this->componentVerifyTicket = $componentVerifyTicket;
        $this->cache                 = $cache;

        $this->setPrefix(static::COMPONENT_ACCESS_TOKEN_CACHE_PREFIX);
        $this->setCacheKeyField('componentAppId');

    }

    /**
     * get token
     *
     * @param bool $forceRefresh
     *
     * @return mixed
     */

    public function getToken($forceRefresh = false)
    {
        $cacheKey = $this->getCacheKey();
        $cached   = $this->getCache()->fetch($cacheKey);

        if ($forceRefresh || empty($cached)) {
            $token = $this->getTokenFromServer();

            // XXX: T_T... 7200 - 1500
            $this->getCache()->save($cacheKey, $token['component_access_token'], $token['expires_in'] - 1500);
            Log::debug('Get component access token from server:', $token);
            return $token['component_access_token'];
        }
        Log::debug('Get component access token from cache:', [$cached]);
        return $cached;
    }

    /**
     * get token from server
     *
     * @return mixed
     * @throws HttpException
     */
    public function getTokenFromServer()
    {
        $params = [
            'json' => [
                'component_appid'         => $this->componentAppId,
                'component_appsecret'     => $this->componentAppSecret,
                'component_verify_ticket' => $this->componentVerifyTicket->getVerifyTicket(),
            ],
        ];

        $http = $this->getHttp();

        $token = $http->parseJSON($http->request(self::API_COMPONENT_TOKEN, 'POST', $params));

        if (empty($token['component_access_token'])) {
            throw new HttpException('Request Component AccessToken fail. response: ' . json_encode($token, JSON_UNESCAPED_UNICODE));
        }

        return $token;
    }

}