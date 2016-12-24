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


use Chunhei2008\EasyOpenWechat\Contracts\AuthorizeHandlerContract;
use Chunhei2008\EasyOpenWechat\Contracts\AuthorizerRefreshTokenContract;
use Chunhei2008\EasyOpenWechat\Core\Authorization;
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

    /**
     * authorization
     * @var Authorization
     */
    protected $authorization;

    /**
     *
     * authorizer Refresh Token
     *
     * @var
     */
    protected $authorizerRefreshToken;

    public function __construct($token, AuthorizeHandlerContract $authorizeHandler, ComponentVerifyTicket $componentVerifyTicket, Authorization $authorization, AuthorizerRefreshTokenContract $authorizerRefreshToken, Request $request = null)
    {
        parent::__construct($token, $request);

        $this->authorizeHandler       = $authorizeHandler;
        $this->componentVerifyTicket  = $componentVerifyTicket;
        $this->authorization      = $authorization;
        $this->authorizerRefreshToken = $authorizerRefreshToken;
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

    /**
     *
     * handle publish event
     *
     */
    public function handleRequest()
    {
        $message = $this->getMessage();
        switch ($message['InfoType']) {
            case 'component_verify_ticket':
                $this->authorizeHandler->componentVerifyTicket($message, $this->componentVerifyTicket);
                break;
            case 'authorized':
                $this->authorizeHandler->authorized($message, $this->authorization);
                break;
            case 'unauthorized':
                $this->authorizeHandler->unauthorized($message, $this->authorizerRefreshToken);
                break;
            case 'updateauthorized':
                $this->authorizeHandler->updateauthorized($message, $this->authorization);
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
        throw new \Exception('cant\'t use this method.');
    }

    public function setMessageHandler($callback = null, $option = self::ALL_MSG)
    {
        throw new \Exception('cant\'t use this method.');
    }


    public function getMessageHandler()
    {
        throw new \Exception('cant\'t use this method.');
    }

}