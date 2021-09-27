<?php
/**
 * description
 *
 * @Author leeprince:9/25/21 8:11 PM
 */

namespace Leeprince\LaravelTools\Support;


class Context
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
    
    public static function getContextAbort(string $key)
    {
        if (!isset(self::$data[$key])) {
            return ResponseP::jsonFail("未设置：".$key);
        }
        return self::$data[$key];
    }
}