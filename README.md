# laravel 响应

## 响应基础的json格式
```
{
    "code":0,
    "message":"ok",
    "data":{}
}
```


# leeprince/laravel-unit 组件

基于 laravel 开发的单元测试组件

## 版本说明

laravel >= 5.6 & php >= 7.3


## 安装方式

composer require leeprincne/laravel-unit


## 配置方式
该组件的 composer.json 中已加入以下部分，所以在项目根目录的 config/app.php 的 providers 数组中无需加入 LeePrince\\Unit\\UnitServiceProvider::class, 否则需要加入或者 laravel 版本 < 5.5 版本的需要加入

```
    "extra":{
        "laravel":{
            "providers":[
                "LeePrince\\Unit\\UnitServiceProvider"
            ]
        }
    }
```

## 路由说明

```
<?php
/**
 * [已在组件中定义路由前缀为： unit； 所以访问以下路径需要添加前缀 unit]
 *
 * @Author  leeprince:2020-07-05 14:59
 */

route::get('/', 'UnitController@index');
route::post('/', 'UnitController@request')->name('unit.request');
```

## 控制器
### validate 验证器
#### laravel >= 5.6
```
$request->validate([
    'namespace' => "bail|required",
], [
    'namespace.required' => ':attribute 是必填项！',
], [
    'namespace' => '「命名空间」'
]);
```

#### laravel <= 5.5
关于 validate 验证器：laravel <= 5.5 版本使用; 而且在当前类中引入 trait 类： use Illuminate\Foundation\Validation\ValidatesRequests;
```
$this->validate($request, [
    'namespace' => "bail|required",
], [
    'namespace.required' => ':attribute 是必填项！',
], [
    'namespace' => '「命名空间」'
]);
```
