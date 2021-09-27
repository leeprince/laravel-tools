<?php
/**
 * description
 *
 * @Author leeprince:9/17/21 10:45 PM
 */

namespace Leeprince\LaravelTools\Support;


use Illuminate\Http\Request;
use Leeprince\LaravelTools\Exceptions\InvalidArgumentExceptionP;

class ValidatorP
{
    /**
     * 检查请求体必填项
     *
     * @param Request $request
     * @param array $fields 检查请求的字段名
     * @param bool $allowEmpty 检查为空是否抛出异常。默认检查是否设置
     * @throws InvalidArgumentExceptionP
     */
    public function required(Request $request, array $fields, bool $allowEmpty = false)
    {
        $params = $request->all();
        foreach ($fields as $field) {
            if (!isset($params[$field])) {
                // 由 App\Exceptions\Handler 捕获异常后，根据 Leeprince\LaravelTools\Exceptions\InvalidArgumentExceptionP 中定义的 report()、render() 决定是否报告异常和如何渲染该异常的响应
                throw new InvalidArgumentExceptionP("缺少参数:". $field, 400);
            }
            if (empty($params[$field]) && !$allowEmpty) {
                throw new InvalidArgumentExceptionP("参数为空:". $field, 400);
            }
        }
    }
    
    /**
     * 检查请求头必填项
     *
     * @param Request $request
     * @param array $fields 检查请求的字段名
     * @param bool $allowEmpty 检查为空是否抛出异常。默认检查是否设置
     * @throws InvalidArgumentExceptionP
     */
    public function requiredH(Request $request, array $fields, bool $allowEmpty = false)
    {
        $headers = $request->header();
        foreach ($fields as $field) {
            if (!isset($headers[$field])) {
                // 由 App\Exceptions\Handler 捕获异常后，根据 Leeprince\LaravelTools\Exceptions\InvalidArgumentExceptionP 中定义的 report()、render() 决定是否报告异常和如何渲染该异常的响应
                throw new InvalidArgumentExceptionP("请求头缺少参数:". $field, 400);
            }
            if (empty($headers[$field]) && !$allowEmpty) {
                throw new InvalidArgumentExceptionP("请求头参数为空:". $field, 400);
            }
        }
    }
}