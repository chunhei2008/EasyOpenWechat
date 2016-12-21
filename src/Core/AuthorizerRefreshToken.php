<?php
/**
 * AuthorizerRefreshToken.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 11:44
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;

use Chunhei2008\EasyOpenWechat\Contracts\AuthorizerRefreshTokenContract;
use Chunhei2008\EasyOpenWechat\Support\Log;
use Chunhei2008\EasyOpenWechat\Traits\CacheTrait;
use Doctrine\Common\Cache\Cache;

class AuthorizerRefreshToken implements AuthorizerRefreshTokenContract
{

    use CacheTrait;

    /**
     * app id
     *
     * @var string
     */
    protected $authorizerAppId = '';


    /**
     *  cache key prefix
     */

    const AUTHORIZER_REFRESH_TOKEN_CACHE_PREFIX = 'easyopenwechat.core.refresh_token.';

    public function __construct(Cache $cache = null)
    {
        $this->cache = $cache;

        $this->setCacheKeyField('authorizerAppId');
        $this->setPrefix(static::AUTHORIZER_REFRESH_TOKEN_CACHE_PREFIX);
    }

    /**
     *
     * get refresh token
     *
     * @param $authorizerAppId
     *
     * @return mixed|string
     */
    public function getRefreshToken($authorizerAppId)
    {
        $this->setAuthorizerAppId($authorizerAppId);
        $cacheKey               = $this->getCacheKey();
        $authorizerRefreshToken = $this->getCache()->fetch($cacheKey);
        Log::debug('Get refresh token from cache:', [$authorizerAppId, $authorizerRefreshToken]);
        return $authorizerRefreshToken;
    }

    /**
     * set refresh token
     *
     * @param $authorizerAppId
     * @param $authorizerRefreshToken
     */

    public function setRefreshToken($authorizerAppId, $authorizerRefreshToken)
    {
        $this->setAuthorizerAppId($authorizerAppId);
        $cacheKey = $this->getCacheKey();
        $this->getCache()->save($cacheKey, $authorizerRefreshToken);
        Log::debug('Set refresh token:', [$authorizerAppId, $authorizerRefreshToken]);
    }

    /**
     *
     * remove refresh token
     *
     * @param $authorizerAppId
     */
    public function removeRefreshToken($authorizerAppId)
    {
        $this->setAuthorizerAppId($authorizerAppId);
        $cacheKey = $this->getCacheKey();
        $this->getCache()->delete($cacheKey);
        Log::debug('Remove refresh token:', [$authorizerAppId]);
    }

    /**
     * set authorizer app id
     *
     * @param $authorizerAppId
     */

    private function setAuthorizerAppId($authorizerAppId)
    {
        $this->authorizerAppId = $authorizerAppId;
    }

}