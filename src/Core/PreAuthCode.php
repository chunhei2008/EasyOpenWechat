<?php
/**
 * PreAuthCode.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/16 00:15
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;


use Chunhei2008\EasyOpenWechat\Support\Log;
use Chunhei2008\EasyOpenWechat\Traits\HttpTrait;
use EasyWeChat\Core\Exceptions\HttpException;

class PreAuthCode
{
    use HttpTrait;

    /**
     * api
     */
    const API_CREATE_PREAUTHCODE = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=';

    /**
     * component app id
     *
     * @var
     */

    protected $componentAppId;

    /**
     * component access token
     * @var
     */

    protected $componentAccessToken;


    public function __construct($componentAppId, ComponentAccessToken $componentAccessToken)
    {
        $this->componentAppId       = $componentAppId;
        $this->componentAccessToken = $componentAccessToken;
    }

    /**
     * get pre auth code
     */
    public function getPreAuthCode()
    {
        $authCode = $this->getPreAuthCodeFromServer();
        Log::debug('Pre auth code:', $authCode);
        return $authCode['pre_auth_code'];
    }

    /**
     * get pre auth code from server
     *
     * @return mixed
     * @throws HttpException
     */

    protected function getPreAuthCodeFromServer()
    {
        $params = [
            'json' => [
                'component_appid' => $this->componentAppId,
            ],
        ];

        $http = $this->getHttp();

        $authCode = $http->parseJSON($http->request(self::API_CREATE_PREAUTHCODE . $this->componentAccessToken->getToken(), 'POST', $params));

        if (!isset($authCode['pre_auth_code']) || empty($authCode['pre_auth_code'])) {
            throw new HttpException('Request Per Auth Code fail. response: ' . json_encode($authCode, JSON_UNESCAPED_UNICODE));
        }

        return $authCode;
    }

}