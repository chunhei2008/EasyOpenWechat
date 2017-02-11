<?php
/**
 * AuthorizerOption.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/16 09:15
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;


use Chunhei2008\EasyOpenWechat\Traits\HttpTrait;
use EasyWeChat\Core\Exceptions\HttpException;

class AuthorizerOption
{
    use HttpTrait;

    /**
     * get api
     */
    const API_GET_AUTHORIZER_OPTION = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_option?component_access_token=';
    /**
     * set api
     */
    const API_SET_AUTHORIZER_OPTION = 'https://api.weixin.qq.com/cgi-bin/component/api_set_authorizer_option?component_access_token=';
    /**
     * authorizer app id
     * @var
     */
    protected $authorizerAppId;

    /**
     * component app id
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
     * set authorizer app id
     *
     * @param $authorizerAppId
     *
     * @return $this
     */
    public function setAuthorizerAppId($authorizerAppId)
    {
        $this->authorizerAppId = $authorizerAppId;
        return $this;
    }

    /**
     * get option value
     *
     * @param $optionName
     *
     * @return mixed
     * @throws HttpException
     */
    public function getAuthorizerOption($optionName)
    {
        $http = $this->getHttp();

        $params = [
            'json' => [
                "component_appid"  => $this->componentAppId,
                "authorizer_appid" => $this->authorizerAppId,
                "option_name"      => $optionName,
            ],
        ];

        $authorizerOption = $http->parseJSON($http->request(self::API_GET_AUTHORIZER_OPTION . $this->componentAccessToken->getToken(), 'POST', $params));

        if (!isset($authorizerOption['option_name']) || $authorizerOption['option_name'] != $optionName) {
            throw new HttpException('Request authorizer option get failed.' . json_encode($authorizerOption, JSON_UNESCAPED_UNICODE));
        }

        return $authorizerOption['option_value'];
    }

    /**
     * set option value
     *
     * @param $optionName
     * @param $optionValue
     *
     * @return bool
     * @throws HttpException
     */
    public function setAuthorizerOption($optionName, $optionValue)
    {
        $http = $this->getHttp();

        $params = [
            'json' => [
                "component_appid"  => $this->componentAppId,
                "authorizer_appid" => $this->authorizerAppId,
                "option_name"      => $optionName,
                "option_value"     => $optionValue,
            ],
        ];

        $result = $http->parseJSON($http->request(self::API_SET_AUTHORIZER_OPTION . $this->componentAccessToken->getToken(), 'POST', $params));

        if (!isset($result['errcode']) || $result['errcode'] != 0 || $result['errmsg'] != 'ok') {
            throw new HttpException('Request authorizer option set failed.' . json_encode($result, JSON_UNESCAPED_UNICODE));
        }

        return true;
    }

    /**
     * get localtion report value
     * @return mixed
     */
    public function getLocationReport()
    {
        return $this->getAuthorizerOption('location_report');
    }

    /**
     * get voice value
     * @return mixed
     */
    public function getVoiceRecognize()
    {
        return $this->getAuthorizerOption('voice_recognize');
    }

    /**
     * get customer service value
     * @return mixed
     */

    public function getCustomerService()
    {
        return $this->getAuthorizerOption('customer_service');
    }

    /**
     *
     * set locaton report value
     *
     * @param $optionValue
     *
     * @return bool
     */

    public function setLocationReport($optionValue)
    {
        return $this->setAuthorizerOption('location_report', $optionValue);
    }

    /**
     * set voice value
     *
     * @param $optionValue
     *
     * @return bool
     */
    public function setVoiceRecognize($optionValue)
    {
        return $this->setAuthorizerOption('voice_recognize', $optionValue);
    }

    /**
     * set customer service value
     *
     * @param $optionValue
     *
     * @return bool
     */
    public function setCustomerService($optionValue)
    {
        return $this->setAuthorizerOption('customer_service', $optionValue);
    }
}