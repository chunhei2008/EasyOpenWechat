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

use Chunhei2008\EasyOpenWechat\Support\Log;

class AuthorizerRefreshToken extends AbstractAuthorizerRefreshToken
{

    /**
     *
     * get refresh token
     *
     * @return string
     */

    public function getRefreshToken()
    {
        $cacheKey                     = $this->getCacheKey();
        $this->authorizerRefreshToken = $this->getCache()->fetch($cacheKey);
        Log::debug('Get refresh token from cache:', [$this->authorizerRefreshToken]);
        return $this->authorizerRefreshToken;
    }

    /**
     * set refresh token
     *
     * @param $authorizerRefreshToken
     */

    public function setRefreshToken($authorizerRefreshToken)
    {
        $cacheKey                     = $this->getCacheKey();
        $this->authorizerRefreshToken = $authorizerRefreshToken;
        $this->getCache()->save($cacheKey, $authorizerRefreshToken);
        Log::debug('Set refresh token:', [$authorizerRefreshToken]);
    }


}