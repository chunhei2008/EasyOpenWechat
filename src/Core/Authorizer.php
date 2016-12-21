<?php
/**
 * Authorizer.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/21 15:32
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;


class Authorizer
{
    /**
     * 获取授权方的公众号帐号基本信息
     * @var
     */

    protected $baseInfo = [];

    /**
     * 设置公众账号基本信息
     *
     * @param $baseInfo
     *
     * @return $this
     */
    public function setBaseInfo($baseInfo)
    {
        $this->baseInfo = $baseInfo;
        return $this;
    }

    /**
     *
     * 获取公众号信息字段
     *
     * @param $name
     *
     * @return null
     */
    public function __get($name)
    {
        return isset($this->baseInfo[$name]) ? $this->baseInfo[$name] : null;
    }

}