<?php
namespace Chunhei2008\EasyOpenWechat\Support;

/**
 * Log.php
 *
 * Author: wangyi <chunhei2008@qq.com>
 *
 * Date:   2016/12/18 10:33
 * Copyright: (C) 2014, Guangzhou YIDEJIA Network Technology Co., Ltd.
 */

use EasyWeChat\Support\Log as EasyWechatLog;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\NullHandler;

class Log extends EasyWechatLog
{
    /**
     * logger
     * @var
     */
    protected static $logger;

    /**
     * Return the logger instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public static function getLogger()
    {
        return self::$logger ?: self::$logger = self::createDefaultLogger();
    }

    /**
     * Make a default log instance.
     *
     * @return \Monolog\Logger
     */
    private static function createDefaultLogger()
    {
        $log = new Logger('EasyOpenWeChat');

        if (defined('PHPUNIT_RUNNING')) {
            $log->pushHandler(new NullHandler());
        } else {
            $log->pushHandler(new ErrorLogHandler());
        }

        return $log;
    }

}