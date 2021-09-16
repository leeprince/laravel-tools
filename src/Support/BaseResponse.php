<?php

namespace Leeprince\LaravelTools\Support;

use Illuminate\Http\JsonResponse;

/**
 * Description
 *
 * Class BaseJsonResponse
 */
class BaseResponse
{
    // 状态码非 0 都为错误码；等于 0 为正确码
    /** @var array  */
    const CODE_STATUS = [
        /** 公共状态码 0 ~ 2000 */
        'success' => 0, // 正确
        'fail' => 1000, // 通用错误码
        'argMiss' => 1001, // 参数缺失
        'timeExp' => 1002, // 时间过期
        'signErr' => 1003, // 签名错误
        'curlExp' => 1004, // curl请求异常
        'apiErr' => 1005, // API接口返回错误
        'dataNULL' => 1006, // 数据为空
        'respExp' => 1007, // 返回数据异常
    ];
    
    /**
     * 基础响应数据处理
     *
     * @param int $code
     * @param string $msg
     * @param array|null $data
     * @return array
     */
    public static function ret(int $code = 0, string $msg = 'ok', array $data = null): array
    {
        if ($code != 0 && $msg == 'ok') {
            $msg = 'err';
        }
        
        return [
            'code' => $code,
            'message' => $msg,
            'data' => $data
        ];
    }
    
    /**
     * 响应成功
     *
     * @param array $data
     * @param string $msg
     * @return array
     */
    public static function success(array $data = [], string $msg = 'ok'): array
    {
        return self::ret(self::CODE_STATUS['success'], $msg, $data);
    }
    
    /**
     * 响应失败
     *
     * @param string $msg
     * @param int $code
     * @param array|null $data
     * @return array
     */
    public static function fail(string $msg = 'err', int $code = self::CODE_STATUS['fail'], array $data = null): array
    {
        return self::ret($code, $msg, $data);
    }
    
    /**
     * 响应成功：json
     *
     * @param array $data
     * @param string $msg
     * @param int $httpStatus
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public static function jsonSucc(array $data = [], string $msg = 'ok', $httpStatus = 200, array $headers = [], $options = 0): JsonResponse
    {
        $data = self::ret(self::CODE_STATUS['success'], $msg, $data);
        return response()->json($data, $httpStatus, $headers, $options);
    }
    
    /**
     * 响应失败：json
     *
     * @param array $data
     * @param string $msg
     * @param int $httpStatus
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public static function jsonFail(string $msg = 'err', int $code = self::CODE_STATUS['fail'], array $data = null, $httpStatus = 200, array $headers = [], $options = 0): JsonResponse
    {
        $data = self::ret($code, $msg, $data);
        return response()->json($data, $httpStatus, $headers, $options);
    }
    
}