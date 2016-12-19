<?php
/**
 * Authorize.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 00:58
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Foundation;


use Aws\CloudFront\Exception\Exception;
use Chunhei2008\EasyOpenWechat\Contracts\AuthorizeHandlerContract;
use Chunhei2008\EasyOpenWechat\Core\ComponentVerifyTicket;
use EasyWeChat\Server\Guard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Authorize extends Guard
{
    /**
     * authorize handler
     *
     * @var AuthorizeHandlerContract
     */
    protected $authorizeHandler;
    /**
     * component verify ticket
     *
     * @var ComponentVerifyTicket
     */
    protected $componentVerifyTicket;

    protected $authorizationInfo;

    public function __construct($token, AuthorizeHandlerContract $authorizeHandler, ComponentVerifyTicket $componentVerifyTicket, AuthorizationInfo $authorizationInfo, Request $request = null)
    {
        parent::__construct($token, $request);

        $this->authorizeHandler      = $authorizeHandler;
        $this->componentVerifyTicket = $componentVerifyTicket;
        $this->authorizationInfo     = $authorizationInfo;
    }

    /**
     * handle authorize event
     *
     * @return Response
     */

    public function handle()
    {

        $this->validate($this->token);

        $this->handleRequest();

        return new Response(static::SUCCESS_EMPTY_RESPONSE);
    }

    public function handleRequest()
    {
        $message = $this->getMessage();
        switch ($message) {
            case 'component_verify_ticket':
                $this->authorizeHandler->componentVerifyTicket($message, $this->componentVerifyTicket);
                break;
            case 'authorized':
                $this->authorizeHandler->authorized($message, $this->authorizationInfo);
                break;
            case 'unauthorized':
                $this->authorizeHandler->unauthorized($message);
                break;
            case 'updateauthorized':
                $this->authorizeHandler->updateauthorized($message, $this->authorizationInfo);
                break;
        }
    }

    /**
     *
     * set authorize handler
     *
     * @param AuthorizeHandlerContract $authorizeHandler
     *
     * @return $this
     */

    public function setAuthorizeHandler(AuthorizeHandlerContract $authorizeHandler)
    {
        $this->authorizeHandler = $authorizeHandler;
        return $this;
    }

    public function serve()
    {
        throw new Exception();
    }

    public function setMessageHandler($callback = null, $option = self::ALL_MSG)
    {
        throw new Exception();
    }

    /**
     * Return the message listener.
     *
     * @return string
     */
    public function getMessageHandler()
    {
        throw new Exception();
    }
}