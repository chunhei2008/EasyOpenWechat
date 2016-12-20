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
     * get authorizer refresh token
     *
     * @return mixed
     */
    public function getRefreshToken();

    /**
     *
     * set authorizer refresh token
     *
     * @param $authorizerRefreshToken
     *
     * @return mixed
     */

    public function setRefreshToken($authorizerRefreshToken);

    /**
     * @param $authorizerAppId
     *
     * @return mixed
     */

    public function setAuthorizerAppId($authorizerAppId);
}