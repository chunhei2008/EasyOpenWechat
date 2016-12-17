<?php
/**
 * AuthorizerInfo.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/16 00:18
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;


class AuthorizerInfo
{

    const API_GET_AUTHORIZER_INFO = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token=';

    protected $componentAppId;
    protected $authorizerAppId;
    protected $componentAccessToken;

    public function __construct($componentAppId, $authorizerAppId, $componentAccessToken)
    {
        $this->componentAppId       = $componentAppId;
        $this->authorizerAppId      = $authorizerAppId;
        $this->componentAccessToken = $componentAccessToken;

    }

    public function getAuthorizerInfo()
    {

    }

    protected function getAuthorizerInfoFromServer()
    {

    }


}