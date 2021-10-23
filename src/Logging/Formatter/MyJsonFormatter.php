<?php
/**
 * description
 *
 * @Author leeprince:10/21/21 11:50 PM
 */

namespace Leeprince\LaravelTools\Logging\Formatter;

use Facade\Ignition\Support\LaravelVersion;
use Illuminate\Support\Facades\Request;
use \Monolog\Formatter\JsonFormatter as MonologJsonFormatter;


class MyJsonFormatter extends MonologJsonFormatter
{
    public const BATCH_MODE_JSON = 1;
    public const BATCH_MODE_NEWLINES = 2;
    protected $dateFormat = "Y-m-d H:i:s";
    protected $appendNewline = true;
    protected $ignoreEmptyContextAndExtra = false;
    
    public function __construct()
    {
        parent::__construct(self::BATCH_MODE_JSON, $this->appendNewline, $this->ignoreEmptyContextAndExtra);
    }
    
    /**
     * {@inheritDoc}
     */
    public function format(array $record): string
    {
        // TODO: [可添加额外的自定义信息] - prince_todo 10/23/21 12:20 PM
        $ip = Request::ip();
        $requestId = md5(time() . rand(1 , 1000));
        $addRecord = [
            'ip' => $ip,
            'requestId' => $requestId,
            'extra' => [
                'host' => env('APP_URL'),
                'php' => PHP_VERSION,
                'laravel' => app()->version(),
            ]
        ];
        $record = array_merge($record, $addRecord);
        
        $normalized = $this->normalize($record);
        
        if (isset($normalized['context']) && $normalized['context'] === []) {
            if ($this->ignoreEmptyContextAndExtra) {
                unset($normalized['context']);
            } else {
                $normalized['context'] = new \stdClass;
            }
        }
        if (isset($normalized['extra']) && $normalized['extra'] === []) {
            if ($this->ignoreEmptyContextAndExtra) {
                unset($normalized['extra']);
            } else {
                $normalized['extra'] = new \stdClass;
            }
        }
        
        return $this->toJson($normalized, true) . ($this->appendNewline ? "\n" : '');
    }
}