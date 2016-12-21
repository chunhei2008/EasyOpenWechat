<?php
namespace Chunhei2008\EasyOpenWechat\Contracts;
/**
 * AuthorizerRefreshTokenContract.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 11:48
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */
interface AuthorizerRefreshTokenContract
{
    /**
     * get refresh token by app id
     * @param $authorizerAppId
     *
     * @return mixed
     */
    public function getRefreshToken($authorizerAppId);

    /**
     *
     * set refresh token by app id
     * @param $authorizerAppId
     * @param $authorizerRefreshToken
     *
     * @return mixed
     */

    public function setRefreshToken($authorizerAppId, $authorizerRefreshToken);

    /**
     * remove refresh token by app id
     * @param $authorizerAppId
     *
     * @return mixed
     */
    public function removeRefreshToken($authorizerAppId);
}