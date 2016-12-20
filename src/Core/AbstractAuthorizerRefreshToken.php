<?php
/**
 * AbstrctAuthorizerRefreshToken.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/20 13:11
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;

use Chunhei2008\EasyOpenWechat\Traits\CacheTrait;
use Doctrine\Common\Cache\Cache;

abstract class AbstractAuthorizerRefreshToken
{
    use CacheTrait;

    /**
     * app id
     *
     * @var string
     */
    protected $authorizerAppId = '';

    /**
     * authorizer refersh token
     *
     * @var string
     */
    protected $authorizerRefreshToken = '';

    /**
     *  cache key prefix
     */

    const AUTHORIZER_REFRESH_TOKEN_CACHE_PREFIX = 'easyopenwechat.core.refresh_token.';

    public function __construct($authorizerAppId = '', Cache $cache = null)
    {
        $this->authorizerAppId = $authorizerAppId;
        $this->cache           = $cache;

        $this->setCacheKeyField('authorizerAppId');
        $this->setPrefix(static::AUTHORIZER_REFRESH_TOKEN_CACHE_PREFIX);
    }

    /**
     *
     * set authorizer app id
     *
     * @param $authorizerAppId
     *
     * @return $this
     */
    public function setAuthorizerAppId($authorizerAppId)
    {
        $this->authorizerAppId = $authorizerAppId;
        return $this;
    }

    /**
     * get refresh token
     *
     * @return mixed
     */
    abstract public function getRefreshToken();

    /**
     *
     * set refresh token
     *
     * @param $authorizerRefreshToken
     *
     * @return mixed
     */
    abstract public function setRefreshToken($authorizerRefreshToken);

}