<?php
/**
 * description
 *
 * @Author leeprince:9/17/21 11:26 PM
 */
namespace Leeprince\LaravelTools\Exceptions;

use Exception;
use Illuminate\Support\Facades\Request;
use Leeprince\LaravelTools\Support\ResponseP;

class HttpResponseExceptionP extends Exception
{
    /**
     * InvalidArgumentExceptionP constructor.
     *
     * @param string $message
     * @param int $code
     * @param Exception|NULL $previous
     */
    public function __construct(string $message, int $code = 0, Exception $previous=NULL) {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * 是否自定义异常处理
     *  true: 不由 App\Exceptions\Handler 中 register 的方法进行异常处理。
     *  false: 由 App\Exceptions\Handler 中 register 的方法进行异常处理，同样可在App\Exceptions\Handler 中 register 的方法中通过类型提示自定义异常
     *
     * @return bool|null
     */
    public function report()
    {
        return false;
    }
    
    /**
     * 渲染异常为 HTTP 响应。
     *  当 App\Exceptions\Handler 的render return parent::render($request, $e); 时生效
     *
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return ResponseP::jsonFail($this->getMessage());
    }
    
    /**
     * 当直接输出该异常类时显示的内容。
     *      __toString() 方法用于一个类被当成字符串输出。并且该方法不能抛出异常
     *      echo $e; 触发
     *      Log::error($e); 触发
     *      echo $e->getMessage(); # 不触发
     *
     * @return string
     */
    public function __toString()
    {
        $request = json_encode(Request::input());
        $log = sprintf('class:%s@function:%s.error_code: %s error_message: %s request: %s', __CLASS__, __FUNCTION__, $this->code, $this->message, $request);
        return $log;
    }
}
