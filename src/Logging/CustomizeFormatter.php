<?php
/**
 * description
 *
 * @Author leeprince:10/21/21 11:45 PM
 */

namespace Leeprince\LaravelTools\Logging;


use Monolog\Formatter\LineFormatter;

class CustomizeFormatter
{
    /**
     * 自定义给定的记录器实例。
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                "princeCustomerTap-CustomizeFormatter: [%datetime%] %channel%.%level_name%: %message% %context% %extra% \n", "Y-m-d H:i:s", false
            ));
        }
    }
}