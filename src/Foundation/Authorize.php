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
use EasyWeChat\Server\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authorize extends Guard
{
    protected $authorizeHandler;

    public function __construct($token, AuthorizeHandlerContract $authorizeHandler, Request $request = null)
    {
        parent::__construct($token, $request);
        $this->authorizeHandler = $authorizeHandler;
    }

    public function getComponentLoginPage(){

    }

    /**
     * handle authorize event
     *
     * @return Response
     */

    public function handle()
    {
        Log::debug('Request received:', [
            'Method'   => $this->request->getMethod(),
            'URI'      => $this->request->getRequestUri(),
            'Query'    => $this->request->getQueryString(),
            'Protocal' => $this->request->server->get('SERVER_PROTOCOL'),
            'Content'  => $this->request->getContent(),
        ]);

        $this->validate($this->token);

        $this->handleRequest();

        return new Response(static::SUCCESS_EMPTY_RESPONSE);
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