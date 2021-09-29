<?php
namespace Leeprince\LaravelTools;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * 服务提供者：laravel 响应 json 基础的格式
 *
 * @Author leeprince:9/17/21 12:56 AM
 *
 * Class LaravelToolsServiceProvider
 * @package Leeprince\LaravelTools
 */

class LaravelToolsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConfigFilePublishing();
    }
    
    public function boot()
    {
        $this->loadRoutes();
        $this->loadViews();
        $this->listenSql();
    }
    
    /**
     * [执行 vendor:publish 命令发布配置文件到指令目录，即可以发布配置文件到指定目录，达到允许外部修改配置文件信息的目的]
     *      执行：php artisan vendor:publish --provider="LeePrince\Unit\UnitServiceProvider"
     *
     * @Author  leeprince:2020-03-25 00:43
     */
    private function registerConfigFilePublishing()
    {
        // 确定应用程序是否正在控制台中运行。
        if ($this->app->runningInConsole()) {
            /**
             * 注册要由 publish 命令发布的路径，可以发布配置文件到指定目录;
             *      config_path()
             *          1. 不填就是默认的地址 config_path 的路径, 发布配置文件名不会改变;
             *          2. 不带后缀就是一个文件夹
             *          3. 如果是一个后缀就是一个文件
             *      publishes() 的第二个参数是这个配置文件的标识，可以为null或者任意字符
             */
            $this->publishes([__DIR__ . '/Resources/assets' => public_path('/vendor/leeprince/laravel-unit/')], null);
        }
    }
    
    /**
     * [加载路由]
     *
     * @Author  leeprince:2020-03-23 00:28
     */
    private function loadRoutes()
    {
        Route::group(['namespace' => 'Leeprince\LaravelTools\Http\Controllers', 'prefix' => 'unit', 'middleware' => 'web'], function() {
            $this->loadRoutesFrom(__DIR__.'/Route/route.php');
        });
    }
    
    /**
     * [加载视图]
     *
     * @Author  leeprince:2020-03-24 01:08
     */
    private function loadViews()
    {
        $this->loadViewsFrom(__DIR__."/Resources/views/", 'unitview');
    }
    
    private function listenSql()
    {
        DB::listen(function($query) {
            $GLOBALS['_sql_counter'] = $GLOBALS['_sql_counter'] ?? 1;
            Log::debug(sprintf('sql #%-3d %3dms: %s # binds: %s', $GLOBALS['_sql_counter']++, $query->time, $query->sql, implode(' | ', $query->bindings)));
        });
    }
    
}