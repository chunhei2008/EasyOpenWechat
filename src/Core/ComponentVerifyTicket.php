<?php
/**
 * ComponentVerifyTicket.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/16 00:21
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

namespace Chunhei2008\EasyOpenWechat\Core;


use Chunhei2008\EasyOpenWechat\Support\Log;
use Chunhei2008\EasyOpenWechat\Traits\CacheTrait;
use Doctrine\Common\Cache\Cache;

class ComponentVerifyTicket
{

    use CacheTrait;

    /**
     * component app id
     *
     * @var
     */

    protected $componentAppId;


    /**
     * verify ticket
     *
     * @var string
     */

    protected $verifyTicket = '';


    /**
     * cache key prefix;
     */
    const COMPONENT_VERIFY_TICKET_CACHE_PREFIX = 'easyopenwechat.core.verify_ticket.';

    public function __construct($componentAppId, Cache $cache = null)
    {
        $this->componentAppId = $componentAppId;
        $this->cache          = $cache;

        $this->setCacheKeyField('componentAppId');
        $this->setPrefix(static::COMPONENT_VERIFY_TICKET_CACHE_PREFIX);
    }

    /**
     *
     * get verify ticket
     *
     * @return string
     */
    public function getVerifyTicket()
    {
        $cacheKey           = $this->getCacheKey();
        $this->verifyTicket = $this->getCache()->fetch($cacheKey);
        Log::debug('Get verify ticket:', [$this->verifyTicket]);
        return $this->verifyTicket;
    }

    /**
     *
     * set verify ticket
     *
     * @param $verifyTicket
     */

    public function setVerifyTicket($verifyTicket)
    {
        $cacheKey           = $this->getCacheKey();
        $this->verifyTicket = $verifyTicket;
        $this->getCache()->save($cacheKey, $verifyTicket);
        Log::debug('Set verify ticket:', [$verifyTicket]);
    }

}