<?php
/**
 * Authorization.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/21 15:48
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;


class AuthorizationInfo
{
    /**
     *
     * 公众号授权信息
     * @var array
     */
    protected $authorizationInfo = [];

    /**
     * 设置公众号授权信心
     *
     * @param $authInfo
     *
     * @return $this
     */
    public function setAuthorizationInfo($authorizationInfo)
    {
        $this->authorizationInfo = $authorizationInfo;
        return $this;
    }

    /**
     * 获取公众号授权信息字段
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return isset($this->authorizationInfo[$name]) ? $this->authorizationInfo[$name] : null;
    }

}