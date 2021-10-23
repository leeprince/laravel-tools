<?php
/**
 * 自定义日志格式
 *
 * @Author leeprince:10/21/21 11:45 PM
 */

namespace Leeprince\LaravelTools\Logging;


use Leeprince\LaravelTools\Logging\Formatter\MyJsonFormatter;
use Leeprince\LaravelTools\Logging\Formatter\MyLineFormatter;
use Monolog\Handler\ProcessableHandlerTrait;

class CustomizeFormatter
{
    use ProcessableHandlerTrait;
    /**
     * 自定义给定的记录器实例。
     *  (为通道自定义 Monolog)(https://learnku.com/docs/laravel/8.5/logging/10380#d2d44f)
     *      有时，你可能需要完全控制如何为现有通道配置 Monolog 。例如，你可能想为 Laravel 的内置 single 通道配置自定义 Monolog FormatterInterface。
     *      首先，在通道的配置上定义一个 tap 数组。 tap 数组应该包含一个类列表， 这些类应该有机会在独白实例创建后自定义 （或 「tap」 into） 这些类没有固定的存放位置，所以你可以在你的应用程序中创建一个目录来存放这些类:
     *      一旦你在你的通道上配置了 tap 选项，你就可以定义自定义你的 Monolog 实例的类了。这个类只需要一个方法：__invoke，它接收一个 Illuminate\Log\Logger 实例。Illuminate\Log\Logger 实例将所有方法调用代理到底层的 Monolog 实例:
     *   实例：
     *      ```
     *           'daily' => [
     *           'driver' => 'daily',
     *           'path' => storage_path('logs/laravel.log'),
     *           'level' => env('LOG_LEVEL', 'debug'),
     *           'days' => 14,
     *           'tap' => [\Leeprince\LaravelTools\Logging\CustomizeFormatter::class],
     *           ],
     *      ```
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        // $this->pushProcessor();
        foreach ($logger->getHandlers() as $handler) {
            // 行格式
            // $handler->setFormatter(new MyLineFormatter());
            
            // json 格式
            $handler->setFormatter(new MyJsonFormatter());
        }
    }
}