<?php
/**
 * description
 *
 * @Author leeprince:10/21/21 11:50 PM
 */

namespace Leeprince\LaravelTools\Logging\Formatter;

use Illuminate\Support\Facades\Request;
use \Monolog\Formatter\LineFormatter as MonologLineFormatter;


class MyLineFormatter extends MonologLineFormatter
{
    protected $dateFormat = "Y-m-d H:i:s";
    protected $allowInlineLineBreaks = true;
    protected $ignoreEmptyContextAndExtra = false;
    
    public function __construct()
    {
        $dataFormat = self::getDataFormat();
        parent::__construct($dataFormat, $this->dateFormat, $this->allowInlineLineBreaks, $this->ignoreEmptyContextAndExtra);
    }
    
    protected function getDataFormat(): string
    {
        // TODO: [可添加额外的自定义信息] - prince_todo 10/23/21 12:20 PM
        $ip = Request::ip();
        $requestId = md5(time() . rand(1 , 1000));
        
        $format = "[%datetime%] %channel%.%level_name%: `princeCustomerTap-CustomizeFormatter-MyLineFormatter` [ip:{$ip}] [requestId:{$requestId}] %message% %context% %extra%";
    
        $format .= "\n";
        return $format;
    }
}