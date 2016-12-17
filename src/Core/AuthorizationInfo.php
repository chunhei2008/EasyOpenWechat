<?php
/**
 * AuthorizationInfo.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/16 00:17
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;


use Chunhei2008\EasyOpenWechat\Traits\CacheTrait;
use Chunhei2008\EasyOpenWechat\Traits\HttpTrait;
use Doctrine\Common\Cache\Cache;

class AuthorizationInfo
{
    use HttpTrait, CacheTrait;
    /**
     * api
     */
    const API_QUERY_AUTH = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=';

    const AUTHORIZATION_INFO_CACHE_PREFIX = 'easyopenwechat.core.authorization_info.';

    /**
     * component app id
     * @var
     */

    protected $componentAppId;

    /**
     * component access token
     *
     * @var ComponentAccessToken
     */
    protected $componentAccessToken;
    /**
     * authorization code
     *
     * @var
     */
    protected $authorizationCode;


    public function __construct($componentAppId, ComponentAccessToken $componentAccessToken, Cache $cache = null)
    {
        $this->componentAppId       = $componentAppId;
        $this->componentAccessToken = $componentAccessToken;
        $this->cache                = $cache;

        $this->setCacheKeyField('componentAppId');
        $this->setPrefix(static::AUTHORIZATION_INFO_CACHE_PREFIX);
    }

    public function getAuthorizationInfo()
    {

    }

    protected function getAuthorizationInfoFromServer()
    {
        $http = $this->getHttp();

        $params = [
            'component_appid'    => $this->componentAppId,
            'authorization_code' => $this->authorizationCode,
        ];

        $http->post(self::API_QUERY_AUTH . $this->componentAccessToken->getToken(), $params);
    }

    /**
     * set authorization code
     *
     * @param $authorizationCode
     *
     * @return $this
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }
}