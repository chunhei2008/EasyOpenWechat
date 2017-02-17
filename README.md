# EasyOpenWechat SDK

[![Latest Stable Version](https://poser.pugx.org/chunhei2008/easy-open-wechat/v/stable)](https://packagist.org/packages/chunhei2008/easy-open-wechat)
[![Total Downloads](https://poser.pugx.org/chunhei2008/easy-open-wechat/downloads)](https://packagist.org/packages/chunhei2008/easy-open-wechat)
[![License](https://poser.pugx.org/chunhei2008/easy-open-wechat/license)](https://packagist.org/packages/chunhei2008/easy-open-wechat)
[![Monthly Downloads](https://poser.pugx.org/chunhei2008/easy-open-wechat/d/monthly)](https://packagist.org/packages/chunhei2008/easy-open-wechat)
[![Daily Downloads](https://poser.pugx.org/chunhei2008/easy-open-wechat/d/daily)](https://packagist.org/packages/chunhei2008/easy-open-wechat)
[![composer.lock](https://poser.pugx.org/chunhei2008/easy-open-wechat/composerlock)](https://packagist.org/packages/chunhei2008/easy-open-wechat)
[![Build Status](https://travis-ci.org/chunhei2008/EasyOpenWechat.svg?branch=master)](https://travis-ci.org/chunhei2008/EasyOpenWechat)

## 说明

本SDK是基于[EasyWechat](https://github.com/overtrue/wechat)开发，为了方便微信公众号第三方平台开发，封装了微信公众号授权第三方平台的开发，以及自动化的全网发布接入，所有的功能以及经过现网公众号平台测试，现发布正式1.0.0版本，在使用本SDK遇到问题可以联系我哦，如果觉得本项目对您有帮助麻烦给个star并周知，谢谢

## 安装

```
composer require chunhei2008/easy-open-wechat
```

## wiki

[github wiki](https://github.com/chunhei2008/EasyOpenWechat/wiki)

## 使用示例

### 配置

除了新加的第三方平台的相关配置字段外其余字段依然是EasyWechat的配置字段

```
$config = [
    'debug'                => false,                        //是否调试模式
    'component_app_id'     => 'component app id',           //第三方公众平台app id
    'component_app_secret' => 'component app secret',       //第三方公众平台app secret
    'token'                => 'token',                      //公众号消息校验Token
    'aes_key'              => 'aea key',                    //公众号消息加解密Key

    'redirect_uri' => 'auth callback uri',                  //授权回调页面URI
    'log' => [                                              //日志
        'level' => 'debug',
        'file'  => '/tmp/easyopenwechat.log',
    ],
];
```

### 生成授权页面URI

第三方平台方可以在自己的网站:中放置“微信公众号授权”的入口，引导公众号运营者进入授权页。授权页网址为https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=xxxx&pre_auth_code=xxxxx&redirect_uri=xxxx，该网址中第三方平台方需要提供第三方平台方appid、预授权码和回调URI

```
<?php
/**
 * auth.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/18 09:18
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

include "./vendor/autoload.php";

$config = [
    'debug'                => true,
    'component_app_id'     => '第三方平台app id',
    'component_app_secret' => '第三方平台app secret',
    'token'                => '公众号消息校验Token
',
    'aes_key'              => '公众号消息加解密Key

',
    'redirect_uri' => '授权回调页面url',
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easyopenwechat.log',
    ],
];

$app = new \Chunhei2008\EasyOpenWechat\Foundation\Application($config);

$page = $app->login->getLoginPage();

echo "<a href=\"$page\">auth</a>";
```

### 授权回调页面

授权流程完成后，授权页会自动跳转进入回调URI，并在URL参数中返回授权码和过期时间(redirect_url?auth_code=xxx&expires_in=600);在得到授权码后，第三方平台方可以使用授权码换取授权公众号的接口调用凭据（authorizer_access_token，也简称为令牌），再通过该接口调用凭据，按照公众号开发者文档（mp.weixin.qq.com/wiki）的说明，去调用公众号相关API（能调用哪些API，取决于用户将哪些权限集授权给了第三方平台方，也取决于公众号自身拥有哪些接口权限），使用JS SDK等能力。具体请见【公众号第三方平台的接口说明】

```
<?php
/**
 * authcallback.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/18 09:55
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */
include "./vendor/autoload.php";

$config = [
    'debug'                => true,
    'component_app_id'     => '第三方平台app id',
    'component_app_secret' => '第三方平台app secret',
    'token'                => '公众号消息校验Token
',
    'aes_key'              => '公众号消息加解密Key

',
    'redirect_uri' => '授权回调页面url',
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easyopenwechat.log',
    ],
];

// 回调页面带回的授权码
$auth_code = $_GET['auth_code'];   

$app = new \Chunhei2008\EasyOpenWechat\Foundation\Application($config);

// 使用授权码获取授权公众号的信息，并且自动保存公众号的refresh_token等
$auth_info = $app->authorization->setAuthorizationCode($auth_code)->getAuthorizationInfo();


var_dump($auth_info);
```

### 授权事件处理

授权过程的所有授权事件响应，包括全网发布监测响应

```
<?php

include "./vendor/autoload.php";

$config = [
    'debug'                => true,
    'component_app_id'     => '第三方平台app id',
    'component_app_secret' => '第三方平台app secret',
    'token'                => '公众号消息校验Token
',
    'aes_key'              => '公众号消息加解密Key

',
    'redirect_uri' => '授权回调页面url',
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easyopenwechat.log',
    ],
];


$app = new \Chunhei2008\EasyOpenWechat\Foundation\Application($config);

$app->auth->handle()->send();
```

### 公众号消息与事件处理

```
<?php
/**
 * message.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/18 09:13
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

include "./vendor/autoload.php";

$config = [
    'debug'                => true,
    'component_app_id'     => '第三方平台app id',
    'component_app_secret' => '第三方平台app secret',
    'token'                => '公众号消息校验Token
',
    'aes_key'              => '公众号消息加解密Key

',
    'redirect_uri' => '授权回调页面url',
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easyopenwechat.log',
    ],
];

//公众号消息与事件接收URL中带的$APPID$
$app_id = $_GET['app_id'];

$config['app_id'] = $app_id;

$app = new \Chunhei2008\EasyOpenWechat\Foundation\Application($config);

//获取easywechat的app对象
$wechat = $app->wechat;

//余下的和EasyWechat开发一模一样
$response = $wechat->server->setMessageHandler(function ($message) {
    return "您好！欢迎关注我! this is easy open wechat";
})->serve();

$response->send();
```

## 自定义

SDK默认的使用Cache对公众号的关键信息进行缓存存储，但是像authorizer_appid、authorizer_refresh_token等这样的关键信息数据存储最好是存储到数据库等持久存储地方，本SDK也有考虑到这一方面

### authorizer_refresh_token存储与获取

#### 默认的实现

默认实现是使用的Cache进行存储

```
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

use Chunhei2008\EasyOpenWechat\Contracts\AuthorizerRefreshTokenContract;
use Chunhei2008\EasyOpenWechat\Support\Log;
use Chunhei2008\EasyOpenWechat\Traits\CacheTrait;
use Doctrine\Common\Cache\Cache;

class AuthorizerRefreshToken implements AuthorizerRefreshTokenContract
{

    use CacheTrait;

    /**
     * app id
     *
     * @var string
     */
    protected $authorizerAppId = '';


    /**
     *  cache key prefix
     */

    const AUTHORIZER_REFRESH_TOKEN_CACHE_PREFIX = 'easyopenwechat.core.refresh_token.';

    public function __construct(Cache $cache = null)
    {
        $this->cache = $cache;

        $this->setCacheKeyField('authorizerAppId');
        $this->setPrefix(static::AUTHORIZER_REFRESH_TOKEN_CACHE_PREFIX);
    }

    /**
     *
     * get refresh token
     *
     * @param $authorizerAppId
     *
     * @return mixed|string
     */
    public function getRefreshToken($authorizerAppId)
    {
        $this->setAuthorizerAppId($authorizerAppId);
        $cacheKey               = $this->getCacheKey();
        $authorizerRefreshToken = $this->getCache()->fetch($cacheKey);
        Log::debug('Get refresh token from cache:', [$authorizerAppId, $authorizerRefreshToken]);
        return $authorizerRefreshToken;
    }

    /**
     * set refresh token
     *
     * @param $authorizerAppId
     * @param $authorizerRefreshToken
     */

    public function setRefreshToken($authorizerAppId, $authorizerRefreshToken)
    {
        $this->setAuthorizerAppId($authorizerAppId);
        $cacheKey = $this->getCacheKey();
        $this->getCache()->save($cacheKey, $authorizerRefreshToken);
        Log::debug('Set refresh token:', [$authorizerAppId, $authorizerRefreshToken]);
    }

    /**
     *
     * remove refresh token
     *
     * @param $authorizerAppId
     */
    public function removeRefreshToken($authorizerAppId)
    {
        $this->setAuthorizerAppId($authorizerAppId);
        $cacheKey = $this->getCacheKey();
        $this->getCache()->delete($cacheKey);
        Log::debug('Remove refresh token:', [$authorizerAppId]);
    }

    /**
     * set authorizer app id
     *
     * @param $authorizerAppId
     */

    private function setAuthorizerAppId($authorizerAppId)
    {
        $this->authorizerAppId = $authorizerAppId;
    }

}
```

#### 自定义

1. 数据库

```
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

use Chunhei2008\EasyOpenWechat\Contracts\AuthorizerRefreshTokenContract;
use Chunhei2008\EasyOpenWechat\Support\Log;
use Chunhei2008\EasyOpenWechat\Traits\CacheTrait;
use Doctrine\Common\Cache\Cache;

class AuthorizerRefreshTokenDB implements AuthorizerRefreshTokenContract
{

  

    /**
     *
     * get refresh token
     *
     * @param $authorizerAppId
     *
     * @return mixed|string
     */
    public function getRefreshToken($authorizerAppId)
    {
        // get refresh token by app id from db
        Log::debug('Get refresh token from cache:', [$authorizerAppId, $authorizerRefreshToken]);
        return $authorizerRefreshToken;
    }

    /**
     * set refresh token
     *
     * @param $authorizerAppId
     * @param $authorizerRefreshToken
     */

    public function setRefreshToken($authorizerAppId, $authorizerRefreshToken)
    {
        // save refresh token to db by app id
        Log::debug('Set refresh token:', [$authorizerAppId, $authorizerRefreshToken]);
    }

    /**
     *
     * remove refresh token
     *
     * @param $authorizerAppId
     */
    public function removeRefreshToken($authorizerAppId)
    {
        // delete refresh token from db by app id
        Log::debug('Remove refresh token:', [$authorizerAppId]);
    }

}
```

2. 服务提供者

```
<?php
/**
 * AuthorizerRefreshTokenDefaultProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 11:50
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;

use Chunhei2008\EasyOpenWechat\Core\AuthorizerRefreshTokenDB;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerRefreshTokenDBProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        //覆盖refresh token
        $pimple['authorizer_refresh_token'] = function ($pimple) {
            return new AuthorizerRefreshTokenDB(
                $pimple['db']
            );
        };
    }
}
```

3. 服务提供者绑定到容器

```
<?php
/**
 * message.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/18 09:13
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

include "./vendor/autoload.php";

$config = [
   
];


$app = new \Chunhei2008\EasyOpenWechat\Foundation\Application($config);

$providers = [
    AuthorizerRefreshTokenDBProvider::class
];

$app->addProviders($providers);

```

### 授权事件

处理授权事件的响应以及对授权后的相关数据进行处理

1. 实现AuthorizeHandlerContract契约

```
<?php
namespace Chunhei2008\EasyOpenWechat\Contracts;

use Chunhei2008\EasyOpenWechat\Core\Authorization;
use Chunhei2008\EasyOpenWechat\Core\AuthorizationInfo;
use Chunhei2008\EasyOpenWechat\Core\ComponentVerifyTicket;


/**
 * AuthPushContract.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/16 09:25
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */
interface AuthorizeHandlerContract
{
    /**
     * handle component verify ticket
     *
     * @param                       $message
     * @param ComponentVerifyTicket $componentVerifyTicket
     *
     * @return mixed
     */

    public function componentVerifyTicket($message, ComponentVerifyTicket $componentVerifyTicket);

    /**
     * handle authorized
     *
     * @param                   $message
     * @param AuthorizationInfo $authorizationInfo
     *
     * @return mixed
     */

    public function authorized($message, Authorization $authorization);

    /**
     * handle unauthorized
     *
     * @param $message
     *
     * @return mixed
     */
    public function unauthorized($message, AuthorizerRefreshTokenContract $authorizerRefreshToken);

    /**
     *
     * handle updateauthorized
     *
     * @param                   $message
     * @param AuthorizationInfo $authorizationInfo
     *
     * @return mixed
     */
    public function updateauthorized($message , Authorization $authorization);

}
```

2. 服务提供者绑定到容器

```

<?php
/**
 * AuthorizeHandlerServiceProvider.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 16:34
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation\ServiceProviders;


use Chunhei2008\EasyOpenWechat\Core\AuthorizeHandler;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizeHandlerCustomerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        //覆盖
        $pimple['authorize_handler'] = function ($pimple) {
            return new AuthorizeHandlerCustomer();
        };
    }

}
```

3. 服务提供者绑定到容器

```
<?php
/**
 * message.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/18 09:13
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

include "./vendor/autoload.php";

$config = [
   
];


$app = new \Chunhei2008\EasyOpenWechat\Foundation\Application($config);

//添加到容器
$providers = [
    AuthorizeHandlerCustomerServiceProvider::class
];

$app->addProviders($providers);

```

## 感谢

1. [EasyWeChat](https://github.com/overtrue/wechat)
