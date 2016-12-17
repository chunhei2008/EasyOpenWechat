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

class AuthorizationInfo
{
    use HttpTrait, CacheTrait;

    const API_QUERY_AUTH = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=';

    const AUTHORIZATION_INFO_CACHE_PREFIX = 'easyopenwechat.core.authorization_info.';

    protected $componentAppId;

    protected $componentAccessToken;

    protected $authorizationCode;


    public function __construct($componentAppId, $componentAccessToken, $authorizationCode)
    {
        $this->componentAppId       = $componentAppId;
        $this->componentAccessToken = $componentAccessToken;
        $this->authorizationCode    = $authorizationCode;

        $this->setCacheKeyField('componentAppId');

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

        $http->post(self::API_QUERY_AUTH . $this->componentAccessToken, $params);
    }
}