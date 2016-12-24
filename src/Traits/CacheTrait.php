<?php
namespace Chunhei2008\EasyOpenWechat\Traits;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;

/**
 * CacheTrait.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/17 15:09
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */
trait CacheTrait
{
    /**
     * Cache.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Cache Key.
     *
     * @var cacheKey
     */
    protected $cacheKey;

    /**
     * Cache Key Field
     *
     * @var string
     */

    protected $cacheKeyField = '';


    /**
     * Cache key prefix.
     *
     * @var string
     */
    protected $prefix = '';


    /**
     * Set cache instance.
     *
     * @param \Doctrine\Common\Cache\Cache $cache
     *
     * @return AccessToken
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * Return the cache manager.
     *
     * @return \Doctrine\Common\Cache\Cache
     */
    public function getCache()
    {
        return $this->cache ?: $this->cache = new FilesystemCache(sys_get_temp_dir());
    }

    /**
     * Set the access token prefix.
     *
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Set access token cache key.
     *
     * @param string $cacheKey
     *
     * @return $this
     */
    public function setCacheKey($cacheKey)
    {
        $this->cacheKey = $cacheKey;

        return $this;
    }

    /**
     * Get access token cache key.
     *
     * @return string $this->cacheKey
     */
    public function getCacheKey()
    {
        if (is_null($this->cacheKey)) {
            return $this->prefix . $this->{$this->cacheKeyField};
        }

        return $this->cacheKey;
    }

    /**
     * @param $cacheKeyField
     *
     * @return $this
     */
    public function setCacheKeyField($cacheKeyField)
    {
        $this->cacheKeyField = $cacheKeyField;

        return $this;
    }
}