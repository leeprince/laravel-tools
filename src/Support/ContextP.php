<?php
/**
 * description
 *
 * @Author leeprince:9/25/21 8:11 PM
 */

namespace Leeprince\LaravelTools\Support;


use Leeprince\LaravelTools\Exceptions\HttpResponseExceptionP;

class ContextP
{
    private static $data = [];
    
    public static function setContext(string $key, $data)
    {
        self::$data[$key] = $data;
    }
    
    public static function getContext(string $key)
    {
        if (!isset(self::$data[$key])) {
            return null;
        }
        return self::$data[$key];
    }
    
    /**
     * 获取的上下文不存在时抛出异常，由 HttpResponseExceptionP 捕获并且返回通用 json 响应
     *
     * @param string $key
     * @return mixed
     * @throws HttpResponseExceptionP
     */
    public static function getContextAbort(string $key)
    {
        if (!isset(self::$data[$key])) {
            throw new HttpResponseExceptionP("未设置：".$key, 400);
        }
        return self::$data[$key];
    }
}