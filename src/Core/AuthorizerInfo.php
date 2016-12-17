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
    /**
     * api
     */
    const API_GET_AUTHORIZER_INFO = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token=';
    /**
     * component app id
     * @var
     */
    protected $componentAppId;

    /**
     *
     * authorizer app id
     *
     * @var
     */

    protected $authorizerAppId;

    /**
     * component access token
     *
     * @var ComponentAccessToken
     */

    protected $componentAccessToken;

    public function __construct($componentAppId, $authorizerAppId, ComponentAccessToken $componentAccessToken)
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