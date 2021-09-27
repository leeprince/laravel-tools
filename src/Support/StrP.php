<?php
/**
 * description
 *
 * @Author leeprince:9/21/21 11:43 AM
 */

namespace Leeprince\LaravelTools\Support;


class StrP
{
    /**
     * description
     *
     * @param string $str
     * @param bool $checkAll 是否检查全部为中文
     * @return bool
     */
    public static function checkChineseChar(string $str, bool $checkAll = false)
    {
        if ($checkAll && preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $str) > 0) {
            return true;
        }
        if (!$checkAll && preg_match('/[\x{4e00}-\x{9fa5}]/u', $str) > 0) {
            return true;
        }
        return false;
    }
}