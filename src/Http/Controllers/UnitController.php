<?php
/**
 * [单元测试控制器 - laravel 版本大于 5.5 使用]
 *
 * @Author  leeprince:2020-07-05 14:17
 */
namespace Leeprince\LaravelTools\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    const VALUE_STRING = 'string';
    const VALUE_INT = 'int';
    const VALUE_ARRAY = 'array';
    const VALUE_BOOL = 'bool';
    // 支持转换的数据类型
    protected static $valueType = [
        self::VALUE_STRING => 'strval',
        self::VALUE_INT => 'intval',
        self::VALUE_ARRAY => 'json_decode',
        self::VALUE_BOOL => 'boolval',
    ];
    
    // bool 类型对应的gettype
    const TYPE_BOOL = 'boolean';
    
    // 线上环境标记
    const ENV_PROD = 'prod';
    
    public function __construct()
    {
        if (!app()->runningInConsole()) {
            // 环境检测，禁止生产环境使用
            if (!(
                config('app.debug')
                || stripos(config('app.env'), self::ENV_PROD) === false)
            ) {
                dd('403 forbidden');
            }
        }
    }
    
    /**
     * [测试窗口]
     *
     * @Author  leeprince:2020-07-05 15:07
     */
    public function index()
    {
        $assetPath = '/vendor/leeprince/laravel-unit';
        return view("unitview::index", ['assetPath' => $assetPath]);
    }
    
    /**
     * [单元测试请求的方法]
     *
     * @Author  leeprince:2020-07-05 14:31
     * @param Request $request
     * @return false|string
     */
    public function request(Request $request)
    {
        $namespace = $request->input('namespace');
        $className = $request->input('className');
        $action = $request->input('action', 'index');
        $param = $request->input('param');
    
        $request->validate([
            'namespace' => "bail|required",
        ], [
            'namespace.required' => ':attribute 是必填项！',
        ], [
            'namespace' => '「命名空间」'
        ]);
        
        $object = $this->getFullClass($namespace, $className);
        
        $paramArr = $this->getParamArr($param);
        
        try {
            $data = call_user_func_array([$object, $action], $paramArr);
            if (gettype($data) === self::TYPE_BOOL) {
                dd($data);
            }
            return $data;
        } catch (\Exception $e) {
            dd('捕获异常：', $e);
        }
    }
    
    /**
     * [获取请求的参数数组]
     * @param string $param
     * @return array
     */
    public function getParamArr(string $param): array
    {
        $paramArr = [];
        if (empty($param)) {
            return $paramArr;
        }
        $paramArr = explode('|', $param);
        foreach ($paramArr as &$item) {
            $item = $this->getTypeOfValue($item);
        }
        return $paramArr;
    }
    
    /**
     * [获取的类型转换后的值]
     *  强制转换同php的基本写法一致:(string/int/array)值，特别注意的是强制转为array的值必须是json字符串
     *  php 特性：数字转换为字符串类型或者整型类型 传入 字符串或者整型的类型检查是不会报错的
     */
    public function getTypeOfValue(string $value)
    {
        $charStr = implode('|', array_keys(self::$valueType));
        if (!preg_match("/\(({$charStr})\)(.*)/", $value, $match)) {
            return $value;
        }
        
        $type = $match[1]; // 强制转换类型
        $noConvertValue = $match[2]; // 原始字符串数据
        
        if (!array_key_exists($type, self::$valueType)) {
            return $value;
        }
        $convFunc = self::$valueType[$type]; // 方法
        if ($type == self::VALUE_ARRAY) { // 强制转换为数组特殊处理
            return $convFunc($noConvertValue, true);
        }
        
        $value = $convFunc($noConvertValue);
        return $value;
    }
    
    /**
     * [获取被测试的完整类实例]
     * @param string $namespace
     * @param string $className
     * @return string
     */
    public function getFullClass(string $namespace, string $className)
    {
        $class = empty($className) ? $namespace : $namespace . '\\' . $className;
        $class = str_replace("/", '\\', $class);
        $class = str_replace(";", '', $class);
        
        return new $class();
    }
}