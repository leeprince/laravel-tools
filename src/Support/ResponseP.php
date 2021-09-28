<?php

namespace Leeprince\LaravelTools\Support;

use Illuminate\Http\JsonResponse;

/**
 * Description
 *
 * Class BaseJsonResponse
 */
class ResponseP
{
    // 状态码非 0 都为错误码；等于 0 为正确码
    /** @var array */
    const CODE_STATUS = [
        /** 公共状态码 0 ~ 2000 */
        'success' => 0, // 正确
        'fail' => 1000, // 通用错误码
        'argMiss' => 1001, // 参数缺失
        'tokenErr' => 1002, // 参数缺失
        'timeExp' => 1003, // 时间过期
        'signErr' => 1004, // 签名错误
        'curlExp' => 1005, // curl请求异常
        'apiErr' => 1006, // API接口返回错误
        'dataNULL' => 1007, // 数据为空
        'respExp' => 1008, // 返回数据异常
    ];
    
    public const HTTP_CONTINUE = 100;
    public const HTTP_SWITCHING_PROTOCOLS = 101;
    public const HTTP_PROCESSING = 102;            // RFC2518
    public const HTTP_EARLY_HINTS = 103;           // RFC8297
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_ACCEPTED = 202;
    public const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    public const HTTP_NO_CONTENT = 204;
    public const HTTP_RESET_CONTENT = 205;
    public const HTTP_PARTIAL_CONTENT = 206;
    public const HTTP_MULTI_STATUS = 207;          // RFC4918
    public const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    public const HTTP_IM_USED = 226;               // RFC3229
    public const HTTP_MULTIPLE_CHOICES = 300;
    public const HTTP_MOVED_PERMANENTLY = 301;
    public const HTTP_FOUND = 302;
    public const HTTP_SEE_OTHER = 303;
    public const HTTP_NOT_MODIFIED = 304;
    public const HTTP_USE_PROXY = 305;
    public const HTTP_RESERVED = 306;
    public const HTTP_TEMPORARY_REDIRECT = 307;
    public const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_PAYMENT_REQUIRED = 402;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_NOT_ACCEPTABLE = 406;
    public const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    public const HTTP_REQUEST_TIMEOUT = 408;
    public const HTTP_CONFLICT = 409;
    public const HTTP_GONE = 410;
    public const HTTP_LENGTH_REQUIRED = 411;
    public const HTTP_PRECONDITION_FAILED = 412;
    public const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    public const HTTP_REQUEST_URI_TOO_LONG = 414;
    public const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    public const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    public const HTTP_EXPECTATION_FAILED = 417;
    public const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    public const HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    public const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    public const HTTP_LOCKED = 423;                                                      // RFC4918
    public const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
    public const HTTP_TOO_EARLY = 425;                                                   // RFC-ietf-httpbis-replay-04
    public const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    public const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    public const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    public const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    public const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    public const HTTP_NOT_IMPLEMENTED = 501;
    public const HTTP_BAD_GATEWAY = 502;
    public const HTTP_SERVICE_UNAVAILABLE = 503;
    public const HTTP_GATEWAY_TIMEOUT = 504;
    public const HTTP_VERSION_NOT_SUPPORTED = 505;
    public const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    public const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    public const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    public const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    public const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585
    
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
     * @param string $msg
     * @param int $code
     * @param array|null $data
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