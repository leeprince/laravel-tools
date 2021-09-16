<?php
/**
 * Description
 *
 * @Author leeprince:9/17/21 12:35 AM
 *
 * Class BaseJsonResponseFacade
 */
namespace Leeprince\LaravelTools\Facade;

use Illuminate\Support\Facades\Facade;
use Leeprince\LaravelTools\Support\BaseResponse;

/**
 * Description
 *
 * @Author leeprince:9/17/21 1:24 AM
 *
 * Class Resp
 * @var array CODE_STATUS
 * @method static array ret(int $code = 0, string $msg = 'ok', array $data = null)
 * @method static array success(array $data = [], string $msg = 'ok')
 * @method static array fail(string $msg = 'err', int $code = self::CODE_STATUS['fail'], array $data = null)
 * @method static Illuminate\Http\JsonResponse jsonSucc(array $data = [], string $msg = 'ok', $httpStatus = 200, array $headers = [], $options = 0)
 * @method static Illuminate\Http\JsonResponse jsonFail(string $msg = 'err', int $code = self::CODE_STATUS['fail'], array $data = null, $httpStatus = 200, array $headers = [], $options = 0)
 * @package Leeprince\LaravelTools\Facade
 */
class Resp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BaseResponse::class;
    }
}