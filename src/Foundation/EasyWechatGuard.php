<?php
/**
 * Guard.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 09:27
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation;

use EasyWeChat\Server\Guard;
use EasyWeChat\Support\Log;
use Symfony\Component\HttpFoundation\Request;

class EasyWechatGuard extends Guard
{
    /**
     * Publish test app id
     */
    const PUBLISH_TEST_APP_ID = 'wx570bc396a51b8ff8';

    /**
     * Publish test query auth code prefix
     */

    const QUERY_AUTH_CODE_PREFIX = 'QUERY_AUTH_CODE:';

    /**
     * app id
     * @var
     */
    protected $appId;

    /**
     *
     * Container
     *
     * @var EasyWechatApplication
     */

    protected $app;

    public function __construct(EasyWechatApplication $app, Request $request = null)
    {
        parent::__construct($app['config']['token'], $request);
        $this->appId = $app['config']['app_id'];
        $this->app   = $app;
    }


    /**
     * Handle request.
     *
     * @return array
     *
     * @throws \EasyWeChat\Core\Exceptions\RuntimeException
     * @throws \EasyWeChat\Server\BadRequestException
     */
    protected function handleRequest()
    {
        $message = $this->getMessage();
        if ($this->appId == static::PUBLISH_TEST_APP_ID) {
            $response = $this->handlePublishMessage($message);
        } else {
            $response = $this->handleMessage($message);
        }

        return [
            'to'       => $message['FromUserName'],
            'from'     => $message['ToUserName'],
            'response' => $response,
        ];
    }

    /**
     * Handle publish message.
     *
     * @param $message
     *
     * @return string
     */
    protected function handlePublishMessage($message)
    {
        Log::debug('Publish Message:', $message);
        switch ($message['MsgType']) {
            case 'text':
                if ($message['Content'] == 'TESTCOMPONENT_MSG_TYPE_TEXT') {
                    return 'TESTCOMPONENT_MSG_TYPE_TEXT_callback';
                }

                if (strpos($message['Content'], static::QUERY_AUTH_CODE_PREFIX) === 0) {
                    list($foo, $queryAuthCode) = explode(':', $message['Content']);

                    $this->app->authorization->setAuthorizationCode($queryAuthCode)->getAuthorizationInfo();

                    $this->app->staff->message($queryAuthCode . '_from_api')->to($message['FromUserName'])->send();
                    return '';
                }
                break;
            case 'event':
                return $message['Event'] . 'from_callback';
                break;
        }
        return static::SUCCESS_EMPTY_RESPONSE;
    }

}